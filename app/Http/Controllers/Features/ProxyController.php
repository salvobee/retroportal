<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Services\Proxy\ReaderProxyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function __invoke(Request $request, ReaderProxyService $reader): View
    {
        // Read target URL from query string
        $url = (string) $request->query('url', '');

        // Fetch simplified content
        $doc = $reader->fetchSimplified($url);

        // Render inside our legacy-friendly wrapper with header
        return view('pages.proxy', [
            'page_title' => $doc['title'] ?? 'Document',
            'origin_url' => $url,
            'body_html'  => $doc['body'] ?? '<p>Empty.</p>',
        ]);
    }
}
