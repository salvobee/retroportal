<?php

namespace App\Http\Controllers\Features;

use App\Contracts\Research\EncyclopediaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EncyclopediaController extends Controller
{
    public function __invoke(Request $request, EncyclopediaService $wikipedia): View
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
