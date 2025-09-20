<?php

namespace App\Services\Weather;

use App\Contracts\WeatherService;

class MockWeatherService implements WeatherService
{
    /**
     * Mock weather data for demonstration purposes.
     * In production, replace this with OpenWeatherMapService and a valid API key.
     */
    private const MOCK_DATA = [
        'london' => [
            'city' => 'London',
            'country' => 'GB',
            'temperature' => 15.2,
            'description' => 'Partly cloudy',
            'humidity' => 68,
            'pressure' => 1013,
            'wind_speed' => 3.5,
            'icon' => '02d',
        ],
        'rome' => [
            'city' => 'Rome',
            'country' => 'IT',
            'temperature' => 22.8,
            'description' => 'Clear sky',
            'humidity' => 45,
            'pressure' => 1018,
            'wind_speed' => 2.1,
            'icon' => '01d',
        ],
        'paris' => [
            'city' => 'Paris',
            'country' => 'FR',
            'temperature' => 18.5,
            'description' => 'Light rain',
            'humidity' => 78,
            'pressure' => 1008,
            'wind_speed' => 4.2,
            'icon' => '10d',
        ],
        'new york' => [
            'city' => 'New York',
            'country' => 'US',
            'temperature' => 12.3,
            'description' => 'Overcast clouds',
            'humidity' => 72,
            'pressure' => 1015,
            'wind_speed' => 5.8,
            'icon' => '04d',
        ],
        'tokyo' => [
            'city' => 'Tokyo',
            'country' => 'JP',
            'temperature' => 25.1,
            'description' => 'Few clouds',
            'humidity' => 55,
            'pressure' => 1020,
            'wind_speed' => 2.8,
            'icon' => '02d',
        ],
    ];

    /**
     * @inheritDoc
     */
    public function getCurrentWeather(string $city): ?array
    {
        if (empty(trim($city))) {
            return null;
        }

        $cityKey = strtolower(trim($city));
        
        // Check if we have mock data for this city
        if (isset(self::MOCK_DATA[$cityKey])) {
            return self::MOCK_DATA[$cityKey];
        }

        // For unknown cities, generate some realistic mock data
        return [
            'city' => ucwords($city),
            'country' => '',
            'temperature' => round(rand(5, 30) + (rand(0, 9) / 10), 1),
            'description' => $this->getRandomDescription(),
            'humidity' => rand(30, 90),
            'pressure' => rand(995, 1025),
            'wind_speed' => round(rand(0, 15) + (rand(0, 9) / 10), 1),
            'icon' => '01d',
        ];
    }

    private function getRandomDescription(): string
    {
        $descriptions = [
            'Clear sky',
            'Few clouds',
            'Scattered clouds',
            'Broken clouds',
            'Overcast clouds',
            'Light rain',
            'Moderate rain',
            'Partly cloudy',
            'Mostly sunny',
            'Sunny',
        ];

        return $descriptions[array_rand($descriptions)];
    }
}