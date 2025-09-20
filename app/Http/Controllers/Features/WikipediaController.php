<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WikipediaController extends Controller
{
    public function __invoke(Request $request): View
    {
        // NOTE: Later query Wikipedia API server-side and render text-only extracts.
        return view('pages.wikipedia', [
            'page_title' => 'Wikipedia',
            'q' => (string) $request->query('q', ''),
        ]);
    }
}
