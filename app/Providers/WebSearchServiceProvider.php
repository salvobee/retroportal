<?php

namespace App\Providers;

use App\Contracts\WebSearch\WebSearchService;
use App\Services\WebSearch\DuckDuckGoWebSearch;
use Illuminate\Support\ServiceProvider;

class WebSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WebSearchService::class, DuckDuckGoWebSearch::class);
    }
}
