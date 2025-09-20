<?php

namespace App\Providers;

use App\Contracts\WeatherService;
use App\Services\Weather\OpenWeatherMapService;
use App\Services\Weather\MockWeatherService;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Use OpenWeatherMapService if API key is configured, otherwise fallback to mock
        $this->app->bind(WeatherService::class, function ($app) {
            $apiKey = config('services.openweathermap.key');
            
            if (empty($apiKey)) {
                return new MockWeatherService();
            }
            
            return new OpenWeatherMapService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}