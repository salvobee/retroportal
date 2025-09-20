<?php

namespace App\Providers;

use App\Services\Proxy\ParserResolver;
use App\Support\DomainAllowList;
use Illuminate\Support\ServiceProvider;

class ProxyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ParserResolver::class, function ($app) {
            $map = config('retro-proxy.parsers', []);
            return new ParserResolver($map);
        });

        $this->app->singleton(DomainAllowList::class, function ($app) {
            $list = config('retro-proxy.whitelist', []);
            $whitelist_only = config('retro-proxy.whitelist_only');
            return new DomainAllowList($list, $whitelist_only);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
