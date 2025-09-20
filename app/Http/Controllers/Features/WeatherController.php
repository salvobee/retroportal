<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Services\Weather\OpenWeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(private OpenWeatherService $owm) {}

    /** Step 1: form semplice */
    public function form(Request $request)
    {
        return view('pages.weather.form', [
            'city' => (string) $request->query('city', ''),
        ]);
    }

    /** Step 2: mostra i possibili match (geocoding) */
    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|min:2|max:120']);
        $q = $request->string('q');

        try {
            $results = $this->owm->searchCities($q, 10);
        } catch (\Throwable $e) {
            $results = [];
        }

        return view('pages.weather.search', [
            'q'       => $q,
            'results' => $results,
        ]);
    }

    /** Step 3: mostra meteo per coords scelte */
    public function show(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'name' => 'nullable|string|max:120',
            'state' => 'nullable|string|max:120',
            'country' => 'nullable|string|max:2',
        ]);

        try {
            $data = $this->owm->currentByCoords(
                (float) $request->lat,
                (float) $request->lon
            );
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'OWM_RATE_LIMIT') {
                return response()->view('features.weather.limited', [], 429);
            }
            throw $e;
        }

        return view('pages.weather.show', [
            'place' => [
                'name'    => $request->string('name')->toString(),
                'state'   => $request->string('state')->toString(),
                'country' => $request->string('country')->toString(),
            ],
            'data' => $data,
        ]);
    }
}
