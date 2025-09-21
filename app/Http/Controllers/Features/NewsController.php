<?php

namespace App\Http\Controllers\Features;

use App\Contracts\News\NewsSourceService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        private readonly NewsSourceService $newsSourceService
    ) {}

    /**
     * Show news sources organized by category.
     */
    public function index(Request $request): View
    {
        $locale = app()->getLocale() ?? 'en';
        $sourcesByCategory = $this->newsSourceService->getSourcesByCategory($locale);

        return view('pages.news.index', [
            'page_title' => __('ui.pages.news'),
            'sourcesByCategory' => $sourcesByCategory,
        ]);
    }

    /**
     * Show articles from a specific news source.
     */
    public function source(Request $request, string $sourceId): View
    {
        $source = $this->newsSourceService->getSource($sourceId);
        
        if (!$source) {
            abort(404, 'News source not found');
        }

        $articles = $this->newsSourceService->getArticles($sourceId, 25);

        return view('pages.news.source', [
            'page_title' => $source['name'] . ' - ' . __('ui.pages.news'),
            'source' => $source,
            'articles' => $articles,
        ]);
    }
}
