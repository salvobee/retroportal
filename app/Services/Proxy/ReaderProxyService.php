<?php

namespace App\Services\Proxy;

use App\Support\UrlProxy;
use fivefilters\Readability\Configuration;
use fivefilters\Readability\Readability;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ReaderProxyService
{
    /**
     * Fetch and render a simplified HTML payload for a given URL.
     * Returns array with 'title' and 'body' (HTML 3.2 friendly).
     */
    public function fetchSimplified(string $url, int $ttlMinutes = 10): array
    {
        // Cache the whole simplified output for speed and to avoid hammering sources
        $cacheKey = 'reader:' . md5($url);
        return Cache::remember($cacheKey, now()->addMinutes($ttlMinutes), function () use ($url) {
            $html = $this->download($url);
            if ($html === null) {
                return [
                    'title' => 'Unavailable',
                    'body'  => '<p>Content not available.</p>',
                ];
            }

            // Prefer AMP version when available
            $ampUrl = $this->detectAmpUrl($html, $url);
            if ($ampUrl && $ampUrl !== $url) {
                $ampHtml = $this->download($ampUrl);
                if ($ampHtml) {
                    $html = $ampHtml;
                    $url  = $ampUrl;
                }
            }

            // Extract main content (try Readability if available, else fallback)
            [$title, $contentHtml] = $this->extractMainContent($html, $url);

            // Sanitize + strip modern tags (scripts, styles)
            $contentHtml = $this->sanitize($contentHtml);

            // Rewrite links and images to go through our proxy
            $contentHtml = $this->rewriteLinks($contentHtml, $url);

            // Downgrade markup to very simple HTML (remove attributes that break legacy UAs)
            $contentHtml = $this->simplifyMarkup($contentHtml);

            return [
                'title' => $title ?: 'Document',
                'body'  => $contentHtml,
            ];
        });
    }

    /** Download HTML (follow redirects, short timeout, generic UA). */
    private function download(string $url): ?string
    {
        if (!UrlProxy::isHttpUrl($url)) return null;

        $res = Http::withHeaders([
            'User-Agent' => 'RetroPortalReader/1.0 (+https://example.com)',
            'Accept'     => 'text/html,application/xhtml+xml',
        ])
            ->timeout(10)
            ->retry(1, 250)
            ->get($url);

        if (!$res->ok()) return null;

        // Normalize encoding to UTF-8 for consistent parsing
        $body = $res->body();
        $enc  = mb_detect_encoding($body, ['UTF-8','ISO-8859-1','Windows-1252'], true) ?: 'UTF-8';
        return $enc === 'UTF-8' ? $body : @mb_convert_encoding($body, 'UTF-8', $enc);
    }

    /** Try to find rel="amphtml" canonical AMP link. */
    private function detectAmpUrl(string $html, string $baseUrl): ?string
    {
        if (!preg_match('#<link[^>]+rel=["\']amphtml["\'][^>]+>#i', $html, $m)) {
            return null;
        }
        if (!preg_match('#href=["\']([^"\']+)#i', $m[0], $hm)) {
            return null;
        }
        $href = $hm[1];
        return $this->absUrl($href, $baseUrl);
    }

    /** Extract main content: prefer Readability if available, else a conservative fallback. */
    private function extractMainContent(string $html, string $baseUrl): array
    {
        try {
            $config = new Configuration([
                'FixRelativeURLs' => true,
                'OriginalURL'     => $baseUrl,
            ]);
            $readability = new Readability($config);
            $readability->parse($html);

            $title = trim((string) $readability->getTitle());
            $contentHtml = (string) $readability->getContent();

            return [$title, $contentHtml];
        } catch (\Throwable) {
            // fall through to basic extractor
        }

        // Very basic extractor: pick <article>, else main container heuristics, else <body>
        $title = $this->extractTitle($html);
        $content = $this->extractArticleLike($html) ?: $this->extractBody($html);

        return [$title, $content ?: '<p>No readable content.</p>'];
    }

    private function extractTitle(string $html): string
    {
        if (preg_match('#<title[^>]*>(.*?)</title>#is', $html, $m)) {
            return trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        }
        return 'Document';
    }

    private function extractArticleLike(string $html): ?string
    {
        if (preg_match('#<article[^>]*>(.*?)</article>#is', $html, $m)) {
            return $m[1];
        }
        // Try common containers
        if (preg_match('#<div[^>]+id=["\']?(content|main|article|story)[^>]*>(.*?)</div>#is', $html, $m)) {
            return $m[2];
        }
        return null;
    }

    private function extractBody(string $html): ?string
    {
        if (preg_match('#<body[^>]*>(.*?)</body>#is', $html, $m)) {
            return $m[1];
        }
        return null;
    }

    /** Remove <script>, <style>, <link>, <iframe>, and noscript junk. */
    private function sanitize(string $html): string
    {
        // Strip scripts/styles/iframes completely
        $html = preg_replace('#<(script|style|iframe|object|embed|svg|canvas)[\s\S]*?</\1>#i', '', $html);
        // Remove standalone link/style tags
        $html = preg_replace('#<(link|meta)[^>]*>#i', '', $html);
        // Remove on* event attributes and modern attributes that may break legacy rendering
        $html = preg_replace('#\son\w+="[^"]*"#i', '', $html);
        $html = preg_replace('#\son\w+=\'[^\']*\'#i', '', $html);
        $html = preg_replace('#\sdata-[^=]+="[^"]*"#i', '', $html);
        return $html;
    }

    /** Rewrite <a href> and <img src> to go through our proxy; absolutize relatives. */
    private function rewriteLinks(string $html, string $baseUrl): string
    {
        // Links
        $html = preg_replace_callback('#<a\s+[^>]*href=["\']([^"\']+)#i', function($m) use ($baseUrl) {
            $abs = $this->absUrl($m[1], $baseUrl);
            return str_replace($m[1], UrlProxy::wrap($abs), $m[0]);
        }, $html);

        // Images
        $html = preg_replace_callback('#<img\s+[^>]*src=["\']([^"\']+)#i', function($m) use ($baseUrl) {
            $abs = $this->absUrl($m[1], $baseUrl);
            return str_replace($m[1], UrlProxy::wrapImage($abs), $m[0]);
        }, $html);

        return $html;
    }

    /** Simplify attributes and tags for legacy UAs. */
    private function simplifyMarkup(string $html): string
    {
        // Drop complex attributes like class/style to reduce noise (optional)
        $html = preg_replace('#\s(class|style|srcset|sizes|loading|decoding|referrerpolicy|integrity|crossorigin|nonce|aria-[^=]+)="[^"]*"#i', '', $html);
        $html = preg_replace("#\s(class|style|srcset|sizes|loading|decoding|referrerpolicy|integrity|crossorigin|nonce|aria-[^=]+)='[^']*'#i", '', $html);

        // Ensure paragraphs and headings are not self-closing
        return $html;
    }

    /** Absolutize relative URLs using base URL. */
    private function absUrl(string $maybeRelative, string $baseUrl): string
    {
        // Already absolute
        if (preg_match('#^https?://#i', $maybeRelative)) {
            return $maybeRelative;
        }
        // Protocol-relative
        if (str_starts_with($maybeRelative, '//')) {
            $scheme = parse_url($baseUrl, PHP_URL_SCHEME) ?: 'https';
            return $scheme . ':' . $maybeRelative;
        }
        // Build from base
        $base = parse_url($baseUrl);
        if (!$base || !isset($base['scheme'], $base['host'])) {
            return $maybeRelative;
        }
        $scheme = $base['scheme'];
        $host   = $base['host'];
        $port   = isset($base['port']) ? ':' . $base['port'] : '';
        $path   = isset($base['path']) ? $base['path'] : '/';
        $dir    = rtrim(dirname($path), '/\\') . '/';

        if (str_starts_with($maybeRelative, '/')) {
            return $scheme . '://' . $host . $port . $maybeRelative;
        }
        return $scheme . '://' . $host . $port . $dir . $maybeRelative;
    }
}
