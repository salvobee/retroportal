<?php

namespace App\Services\Weather;

use App\Exceptions\Weather\MissingApiKeyException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class OpenWeatherService
{
    private string $key;
    private string $base;
    private string $lang;
    private string $units;

    public function __construct()
    {
        $cfg = config('services.openweather');
        $this->key   = $cfg['key'] ?? '';
        $this->base  = rtrim($cfg['base'] ?? 'https://api.openweathermap.org', '/');
        $this->lang  = $cfg['lang'] ?? 'en';
        $this->units = $cfg['units'] ?? 'metric';
    }

    protected function resolveKey(?string $override = null): string
    {
        $key = trim((string) ($override ?: $this->key));

        if ($key === '') {
            throw new MissingApiKeyException('OpenWeather API key is missing');
        }

        return $key;
    }

    protected function http()
    {
        return Http::throwIf(fn($r) => $r->status() >= 500)
            ->retry(3, 200, function ($exception, $request) {
                if ($exception instanceof RequestException) {
                    $status = optional($exception->response)->status();
                    return in_array($status, [429, 500, 502, 503, 504], true);
                }
                return false;
            });
    }

    /** Step intermedio: ricerca città (geocoding) */
    public function searchCities(string $q, int $limit = 10, ?string $apiKey = null): array
    {
        $resolvedKey = $this->resolveKey($apiKey);

        $key = "owm:geocode:" . md5(strtolower(trim($q))) . ":$limit";
        return Cache::remember($key, now()->addDays(30), function () use ($q, $limit, $resolvedKey) {
            $resp = $this->http()->get($this->base . '/geo/1.0/direct', [
                'q'     => $q,
                'limit' => $limit,
                'appid' => $resolvedKey,
            ]);

            $data = $resp->json();
            if (!is_array($data)) {
                throw new InvalidApiResponseException('Invalid API response');
            }

            return $data;
        });
    }

    /** Meteo corrente per coordinate */
    public function currentByCoords(float $lat, float $lon, ?string $apiKey = null): array
    {
        $resolvedKey = $this->resolveKey($apiKey);

        $key = sprintf("owm:current:%.3f:%.3f:%s:%s", $lat, $lon, $this->lang, $this->units);

        return Cache::remember($key, now()->addMinutes(5), function () use ($lat, $lon, $resolvedKey) {
            $resp = $this->http()->get($this->base . '/data/2.5/weather', [
                'lat'   => $lat,
                'lon'   => $lon,
                'appid' => $resolvedKey,
                'lang'  => $this->lang,
                'units' => $this->units,
            ]);

            if ($resp->status() === 429) {
                throw new \RuntimeException('OWM_RATE_LIMIT');
            }

            $data = $resp->json();
            if (!is_array($data)) {
                throw new InvalidApiResponseException('Invalid API response');
            }

            return $data;
        });
    }
}
