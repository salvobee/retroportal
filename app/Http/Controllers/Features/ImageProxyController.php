<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ImageProxyController extends Controller
{
    /**
     * Fetch an image over HTTPS and serve it over HTTP to legacy browsers.
     * Basic content-type passthrough, short caching.
     */
    public function __invoke(Request $request): Response
    {
        $url = (string) $request->query('url', '');
        if (!preg_match('#^https?://#i', $url)) {
            return response('Bad Request', 400);
        }

        $cacheKey = 'img:' . md5($url);
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return (new Response($cached['body'], 200, [
                'Content-Type'  => $cached['type'],
                'Cache-Control' => 'public, max-age=600',
            ]));
        }

        $res = Http::withHeaders([
            'User-Agent' => 'RetroPortalImageProxy/1.0',
            'Accept'     => 'image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
        ])
            ->timeout(10)
            ->retry(1, 250)
            ->get($url);

        if (!$res->ok()) {
            return response('Not Found', 404);
        }

        $type = $res->header('Content-Type', 'image/jpeg');
        $body = $res->body();

        Cache::put($cacheKey, ['body' => $body, 'type' => $type], now()->addMinutes(10));

        return (new Response($body, 200, [
            'Content-Type'  => $type,
            'Cache-Control' => 'public, max-age=600',
        ]));
    }
}
