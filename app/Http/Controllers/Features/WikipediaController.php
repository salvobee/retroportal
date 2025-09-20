<?php

namespace App\Http\Controllers\Features;

use App\Contracts\WikipediaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WikipediaController extends Controller
{
    public function __invoke(Request $request, WikipediaService $wikipedia): View
    {
        $q = (string) $request->query('q', '');
        $locale = app()->getLocale() ?? 'en';

        $results = $q !== ''
            ? $wikipedia->search($q, $locale, 10)
            : [];

        return view('pages.wikipedia', [
            'page_title' => __('ui.menu.wikipedia'),
            'query'      => $q,
            'results'    => $results,
        ]);
    }
}
