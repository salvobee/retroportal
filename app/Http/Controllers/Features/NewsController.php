<?php

namespace App\Http\Controllers\Features;

use App\Contracts\NewsService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __invoke(Request $request, NewsService $news): View
    {
        // Use app locale (set via middleware/cookie)
        $locale = app()->getLocale() ?? 'en';

        // Fetch latest localized headlines
        $items = $news->latest($locale, limit: 30);

        return view('pages.news', [
            'page_title' => __('ui.pages.news'),
            'items'      => $items,
        ]);
    }
}
