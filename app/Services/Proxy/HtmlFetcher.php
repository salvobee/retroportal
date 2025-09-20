<?php

namespace App\Services\Proxy;

use App\Data\FetchResult;
use App\Support\UrlProxy;
use Illuminate\Support\Facades\Http;

class HtmlFetcher
{
    public function fetch(string $url, bool $preferAmp = true, int $timeout = 10): ?FetchResult
    {
        if (!UrlProxy::isHttpUrl($url)) {
            return null;
        }

        $html = $this->download($url, $timeout);
        if ($html === null) return null;

        $finalUrl = $url;

        if ($preferAmp) {
            $ampUrl = $this->detectAmpUrl($html, $url);
            if ($ampUrl && $ampUrl !== $url) {
                $ampHtml = $this->download($ampUrl, $timeout);
                if ($ampHtml) {
                    $html     = $ampHtml;
                    $finalUrl = $ampUrl;
                }
            }
        }

        return new FetchResult($finalUrl, $html);
    }

    private function download(string $url, int $timeout): ?string
    {
        $res = Http::withHeaders([
            'User-Agent' => 'RetroPortalReader/1.0 (+https://example.com)',
            'Accept'     => 'text/html,application/xhtml+xml',
        ])
            ->timeout($timeout)
            ->retry(1, 250)
            ->get($url);

        if (!$res->ok()) return null;

        $body = $res->body();
        $enc  = mb_detect_encoding($body, ['UTF-8','ISO-8859-1','Windows-1252'], true) ?: 'UTF-8';
        return $enc === 'UTF-8' ? $body : @mb_convert_encoding($body, 'UTF-8', $enc);
    }

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
