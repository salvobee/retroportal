<?php

namespace App\Contracts;

interface WeatherService
{
    /**
     * Fetch current weather data for a given city.
     *
     * @param string $city City name (e.g., 'Rome', 'London')
     * @return array{
     *   city: string,
     *   country: string,
     *   temperature: float,
     *   description: string,
     *   humidity: int,
     *   pressure: int,
     *   wind_speed: float,
     *   icon: string,
     *   error?: string
     * }|null
     */
    public function getCurrentWeather(string $city): ?array;
}