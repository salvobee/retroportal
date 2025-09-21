<?php

namespace App\Services\Proxy\Parsers;

use App\Contracts\Proxy\ContentParser;
use App\Support\UrlProxy;
use fivefilters\Readability\Configuration;
use fivefilters\Readability\Readability;

class GenericContentParser implements ContentParser
{
    public function parse(string $html, string $baseUrl): array
    {
        [$title, $contentHtml] = $this->extractMainContent($html, $baseUrl);
        $contentHtml = $this->sanitize($contentHtml);
        $contentHtml = $this->rewriteLinks($contentHtml, $baseUrl);
        $contentHtml = $this->simplifyMarkup($contentHtml);

        return [
            'title' => $title ?: 'Document',
            'body'  => $contentHtml ?: '<p>No readable content.</p>',
        ];
    }

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
            // fallback
        }

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

    private function sanitize(string $html): string
    {
        $html = preg_replace('#<(script|style|iframe|object|embed|svg|canvas)[\s\S]*?</\1>#i', '', $html);
        $html = preg_replace('#<(link|meta)[^>]*>#i', '', $html);
        $html = preg_replace('#\son\w+="[^"]*"#i', '', $html);
        $html = preg_replace('#\son\w+=\'[^\']*\'#i', '', $html);
        $html = preg_replace('#\sdata-[^=]+="[^"]*"#i', '', $html);
        return $html;
    }

    private function rewriteLinks(string $html, string $baseUrl): string
    {
        $html = preg_replace_callback('#<a\s+[^>]*href=["\']([^"\']+)#i', function($m) use ($baseUrl) {
            $abs = $this->absUrl($m[1], $baseUrl);
            return str_replace($m[1], UrlProxy::wrap($abs), $m[0]);
        }, $html);

        $html = preg_replace_callback('#<img\s+[^>]*src=["\']([^"\']+)#i', function($m) use ($baseUrl) {
            $abs = $this->absUrl($m[1], $baseUrl);
            return str_replace($m[1], UrlProxy::wrapImage($abs), $m[0]);
        }, $html);

        return $html;
    }

    private function simplifyMarkup(string $html): string
    {
        $html = preg_replace('#\s(class|style|srcset|sizes|loading|decoding|referrerpolicy|integrity|crossorigin|nonce|aria-[^=]+)="[^"]*"#i', '', $html);
        $html = preg_replace("#\s(class|style|srcset|sizes|loading|decoding|referrerpolicy|integrity|crossorigin|nonce|aria-[^=]+)='[^']*'#i", '', $html);
        return $html;
    }

    private function absUrl(string $maybeRelative, string $baseUrl): string
    {
        if (preg_match('#^https?://#i', $maybeRelative)) return $maybeRelative;
        if (str_starts_with($maybeRelative, '//')) {
            $scheme = parse_url($baseUrl, PHP_URL_SCHEME) ?: 'https';
            return $scheme . ':' . $maybeRelative;
        }
        $base = parse_url($baseUrl);
        if (!$base || !isset($base['scheme'], $base['host'])) return $maybeRelative;

        $scheme = $base['scheme'];
        $host   = $base['host'];
        $port   = isset($base['port']) ? ':' . $base['port'] : '';
        $path   = $base['path'] ?? '/';
        $dir    = rtrim(dirname($path), '/\\') . '/';

        if (str_starts_with($maybeRelative, '/')) {
            return $scheme . '://' . $host . $port . $maybeRelative;
        }
        return $scheme . '://' . $host . $port . $dir . $maybeRelative;
    }
}
