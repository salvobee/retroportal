<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Services\Search\WebSearchService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WebSearchController extends Controller
{
    public function __invoke(Request $request, WebSearchService $searchService): View
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
}
