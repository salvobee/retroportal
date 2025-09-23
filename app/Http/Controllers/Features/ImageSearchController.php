<?php

namespace App\Http\Controllers\Features;

use App\Contracts\WebSearch\ProgrammableSearchService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ImageSearchController extends Controller
{
    public function __invoke(Request $request, ProgrammableSearchService $search): View
    {
        $q           = (string) $request->query('q', '');
        $onlyDraw    = (bool) $request->boolean('drawings', false); // ?drawings=1 => lineart
        $safe        = $request->query('safe', 'active');           // 'off' | 'active'
        $start       = (int) $request->integer('start', 1);
        $num         = (int) $request->integer('num', 10);

        $results = null;
        $error   = null;

        if (trim($q) !== '') {
            try {
                $results = $search->searchImages($q, [
                    'start'   => $start,
                    'num'     => $num,
                    'safe'    => in_array($safe, ['off','active'], true) ? $safe : 'active',
                    'imgType' => $onlyDraw ? 'lineart' : null,
                ]);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
                $results = null;
            }
        }

        return view('pages.search.images', [
            'page_title' => 'Image Search',
            'q'          => $q,
            'drawings'   => $onlyDraw,
            'safe'       => $safe,
            'start'      => $start,
            'num'        => $num,
            'results'    => $results, // {type:'image', items:[...], total, next_start}
            'error'      => $error,
        ]);
    }
}
