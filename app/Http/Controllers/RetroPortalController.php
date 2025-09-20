<?php

namespace App\Http\Controllers;

use App\Services\Search\SearchService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RetroPortalController extends Controller
{
    public function search(Request $request, SearchService $searchService): View
    {
        $q = (string) $request->query('q', '');
        $results = null;

        // Only hit the API when a non-empty query is provided
        if (trim($q) !== '') {
            $results = $searchService->search($q);
        }

        return view('pages.search', [
            'page_title' => 'Search',
            'q'          => $q,
            'results'    => $results,
        ]);
    }

    public function news(Request $request): View
    {
        // NOTE: Later connect to a news backend (RSS aggregator, GNews API, etc.).
        return view('pages.news', [
            'page_title' => 'News',
        ]);
    }

    public function weather(Request $request): View
    {
        // NOTE: Later integrate with a weather provider (OpenWeather/WeatherAPI).
        return view('pages.weather', [
            'page_title' => 'Weather',
            'city' => (string) $request->query('city', ''),
        ]);
    }

    public function wikipedia(Request $request): View
    {
        // NOTE: Later query Wikipedia API server-side and render text-only extracts.
        return view('pages.wikipedia', [
            'page_title' => 'Wikipedia',
            'q' => (string) $request->query('q', ''),
        ]);
    }
}
