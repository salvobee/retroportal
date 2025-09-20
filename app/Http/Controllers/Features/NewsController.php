<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __invoke(Request $request): View
    {
        // NOTE: Later connect to a news backend (RSS aggregator, GNews API, etc.).
        return view('pages.news', [
            'page_title' => 'News',
        ]);
    }
}
