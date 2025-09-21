<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Services\Proxy\ReaderProxyService;
use App\Support\DomainAllowList;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;

class ProxyController extends Controller
{
    public function __invoke(Request $request, ReaderProxyService $reader, DomainAllowList $allowList): View
    {
        $url = (string) $request->query('url', '');
        $error = null;
        $pageTitle = 'Document';
        $bodyHtml = '<p>Empty.</p>';

        if (!$allowList->isAllowedUrl($url)) {
            return view('pages.proxy', [
                'page_title' => __('Error'),
                'origin_url' => $url,
                'error'      => __('proxy.not_allowed'),
                'body_html'  => null,
            ]);
        }

        try {
            $doc = $reader->fetchSimplified($url);
            $pageTitle = $doc['title'] ?? $pageTitle;
            $bodyHtml  = $doc['body'] ?? $bodyHtml;
        } catch (ConnectionException $e) {
            $pageTitle = __('Error');
            $error = __('proxy.connection_error');
            if (config('app.debug')) {
                $error .= "\n" . $e->getMessage();
            }
            $bodyHtml = null;
        } catch (\Throwable $e) {
            $pageTitle = __('Error');
            $error = __('proxy.generic_error');
            if (config('app.debug')) {
                $error .= "\n" . $e->getMessage();
            }
            $bodyHtml = null;
        }

        return view('pages.proxy', [
            'page_title' => $pageTitle,
            'origin_url' => $url,
            'error'      => $error,
            'body_html'  => $bodyHtml,
        ]);
    }
}
