<?php

namespace App\Providers;

use App\Contracts\WebSearch\ProgrammableSearchService;
use App\Contracts\WebSearch\WebSearchService;
use App\Services\WebSearch\DuckDuckGoWebSearch;
use App\Services\WebSearch\GoogleProgrammableSearch;
use Illuminate\Support\ServiceProvider;

class WebSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WebSearchService::class, DuckDuckGoWebSearch::class);
        $this->app->bind(ProgrammableSearchService::class, GoogleProgrammableSearch::class);
    }
}
