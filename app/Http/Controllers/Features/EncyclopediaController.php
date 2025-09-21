<?php

namespace App\Http\Controllers\Features;

use App\Contracts\Research\EncyclopediaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EncyclopediaController extends Controller
{
    public function __invoke(Request $request, EncyclopediaService $encyclopediaService): View
    {
        $q = (string) $request->query('q', '');
        $locale = app()->getLocale() ?? 'en';

        $results = $q !== ''
            ? $encyclopediaService->search($q, $locale, 10)
            : [];

        return view('pages.encyclopedia', [
            'page_title' => __('encyclopedia.title'),
            'query'      => $q,
            'results'    => $results,
            'source'     => $encyclopediaService->getSourceName(),
        ]);
    }
}
