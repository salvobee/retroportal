<?php

namespace App\Http\Controllers\Features;

use App\Contracts\WeatherService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(
        private readonly WeatherService $weatherService
    ) {}

    public function __invoke(Request $request): View
    {
        $city = trim((string) $request->query('city', ''));
        $weatherData = null;

        if ($city) {
            $weatherData = $this->weatherService->getCurrentWeather($city);
        }

        return view('pages.weather', [
            'page_title' => 'Weather',
            'city' => $city,
            'weather' => $weatherData,
        ]);
    }
}
