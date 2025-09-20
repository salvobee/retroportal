<?php

namespace App\Services\Weather;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class OpenWeatherService
{
    public function __construct(
        private string $key = '',
        private string $base = '',
        private string $lang = 'en',
        private string $units = 'metric',
    ) {
        $cfg = config('services.openweather');
        $this->key   = $cfg['key'];
        $this->base  = rtrim($cfg['base'], '/');
        $this->lang  = $cfg['lang'];
        $this->units = $cfg['units'];
    }

    protected function http()
    {
        return Http::throwIf(fn($r) => $r->status() >= 500)
            ->retry(3, 200, function ($exception, $request) {
                // ritenta su 429 e 5xx
                if ($exception instanceof RequestException) {
                    $status = optional($exception->response)->status();
                    return in_array($status, [429, 500, 502, 503, 504], true);
                }
                return false;
            });
    }

    /** Step intermedio: ricerca città (geocoding) */
    public function searchCities(string $q, int $limit = 10): array
    {
        $key = "owm:geocode:" . md5(strtolower(trim($q))) . ":$limit";
        return Cache::remember($key, now()->addDays(30), function () use ($q, $limit) {
            $resp = $this->http()->get($this->base . '/geo/1.0/direct', [
                'q'     => $q,
                'limit' => $limit,
                'appid' => $this->key,
            ]);
            // Risultato: array di location {name, state, country, lat, lon}
            return $resp->json() ?? [];
        });
    }

    /** Meteo corrente per coordinate */
    public function currentByCoords(float $lat, float $lon): array
    {
        $key = sprintf("owm:current:%.3f:%.3f:%s:%s", $lat, $lon, $this->lang, $this->units);

        // cache aggressiva 5 minuti (riduce chiamate)
        return Cache::remember($key, now()->addMinutes(5), function () use ($lat, $lon) {
            $resp = $this->http()->get($this->base . '/data/2.5/weather', [
                'lat'   => $lat,
                'lon'   => $lon,
                'appid' => $this->key,
                'lang'  => $this->lang,
                'units' => $this->units,
            ]);

            if ($resp->status() === 429) {
                // non mettere in cache il 429: solleva per gestire una view dedicata
                throw new \RuntimeException('OWM_RATE_LIMIT');
            }

            return $resp->json() ?? [];
        });
    }
}
