<?php

namespace App\Http\Controllers\Features;

use App\Contracts\WebSearch\ProgrammableSearchService;
use App\Exceptions\WebSearch\SearchApiException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class WebSearchController extends Controller
{
    public function __invoke(Request $request, ProgrammableSearchService $search): View
    {
        $q     = (string) $request->query('q', '');
        $start = (int) $request->integer('start', 1);
        $num   = (int) $request->integer('num', 10);

        $results = null;
        $error   = null;

        if (trim($q) !== '') {
            try {
                $results = $search->searchWeb($q, [
                    'start' => $start,
                    'num'   => $num,
                    'safe'  => 'active',
                ]);
            } catch (SearchApiException $e) {
                // Log tecnico
                Log::warning('WebSearch API error', [
                    'category' => $e->category(),
                    'message'  => $e->getMessage(),
                    'code'     => $e->getCode(),
                    'query'    => $q,
                ]);

                // Messaggio localizzato per l’utente
                $key = 'web-search.errors.'.$e->category();
                $friendly = Lang::has($key) ? __($key) : __('web-search.errors.generic');

                // Se vuoi mostrare anche il dettaglio tecnico (piccolo e in grigio)
                $error = $friendly.' — '.$e->detail();

            } catch (\Throwable $e) {
                Log::error('WebSearch unexpected error', ['message' => $e->getMessage(), 'query'=>$q]);
                $error = __('web-search.errors.generic').' — '.$e->getMessage();

            }
        }

        return view('pages.search.web', [
            'page_title' => 'Web Search',
            'q'          => $q,
            'start'      => $start,
            'num'        => $num,
            'results'    => $results,
            'error'      => $error,
        ]);
    }
}
