<?php

namespace App\Services\Weather;

use App\Contracts\WeatherService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OpenWeatherMapService implements WeatherService
{

    /**
     * @inheritDoc
     */
    public function getCurrentWeather(string $city): ?array
    {
        if (empty(trim($city))) {
            return null;
        }

        $city = trim($city);
        
        // Cache for 10 minutes to reduce API calls
        $cacheKey = 'weather.openweather.' . strtolower($city);
        
        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($city) {
            $apiKey = config('services.openweathermap.key');
            $apiUrl = config('services.openweathermap.url');
            
            if (empty($apiKey)) {
                return [
                    'city' => $city,
                    'country' => '',
                    'temperature' => 0.0,
                    'description' => 'API key not configured',
                    'humidity' => 0,
                    'pressure' => 0,
                    'wind_speed' => 0.0,
                    'icon' => '',
                    'error' => 'OpenWeatherMap API key not configured'
                ];
            }

            if (empty($apiUrl)) {
                return [
                    'city' => $city,
                    'country' => '',
                    'temperature' => 0.0,
                    'description' => 'API URL not configured',
                    'humidity' => 0,
                    'pressure' => 0,
                    'wind_speed' => 0.0,
                    'icon' => '',
                    'error' => 'OpenWeatherMap API URL not configured'
                ];
            }

            try {
                $response = Http::timeout(8)
                    ->retry(1, 200)
                    ->get($apiUrl, [
                        'q' => $city,
                        'appid' => $apiKey,
                        'units' => 'metric', // Celsius
                        'lang' => 'en'
                    ]);

                if (!$response->successful()) {
                    return [
                        'city' => $city,
                        'country' => '',
                        'temperature' => 0.0,
                        'description' => 'Weather data unavailable',
                        'humidity' => 0,
                        'pressure' => 0,
                        'wind_speed' => 0.0,
                        'icon' => '',
                        'error' => 'API request failed'
                    ];
                }

                $data = $response->json();

                return [
                    'city' => $data['name'] ?? $city,
                    'country' => $data['sys']['country'] ?? '',
                    'temperature' => round($data['main']['temp'] ?? 0.0, 1),
                    'description' => ucfirst($data['weather'][0]['description'] ?? 'Unknown'),
                    'humidity' => $data['main']['humidity'] ?? 0,
                    'pressure' => $data['main']['pressure'] ?? 0,
                    'wind_speed' => round($data['wind']['speed'] ?? 0.0, 1),
                    'icon' => $data['weather'][0]['icon'] ?? '',
                ];

            } catch (\Throwable $e) {
                return [
                    'city' => $city,
                    'country' => '',
                    'temperature' => 0.0,
                    'description' => 'Service temporarily unavailable',
                    'humidity' => 0,
                    'pressure' => 0,
                    'wind_speed' => 0.0,
                    'icon' => '',
                    'error' => 'Connection error'
                ];
            }
        });
    }
}