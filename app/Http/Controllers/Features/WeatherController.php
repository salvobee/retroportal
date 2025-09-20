<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __invoke(Request $request): View
    {
        // NOTE: Later integrate with a weather provider (OpenWeather/WeatherAPI).
        return view('pages.weather', [
            'page_title' => 'Weather',
            'city' => (string) $request->query('city', ''),
        ]);
    }
}
