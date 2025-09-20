<?php
// app/Support/UrlProxy.php

namespace App\Support;

use Illuminate\Support\Str;

class UrlProxy
{
    /**
     * Wrap an external absolute URL into our proxy endpoint.
     * Returns original URL if invalid.
     */
    public static function wrap(?string $url): string
    {
        $url = trim((string) $url);
        if ($url === '' || !self::isHttpUrl($url)) {
            return $url;
        }
        return route('features.proxy', ['url' => $url]);
    }

    /**
     * Wrap an absolute image URL into our image proxy.
     */
    public static function wrapImage(?string $url): string
    {
        $url = trim((string) $url);
        if ($url === '' || !self::isHttpUrl($url)) {
            return $url;
        }
        return route('features.proxy.image', ['url' => $url]);
    }

    /**
     * Basic absolute HTTP/HTTPS URL validation.
     */
    public static function isHttpUrl(string $url): bool
    {
        if (!Str::startsWith($url, ['http://', 'https://'])) return false;
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
