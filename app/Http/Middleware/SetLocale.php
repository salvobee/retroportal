<?php

// app/Http/Middleware/SetLocale.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /** Apply locale from session to the application. */
    public function handle(Request $request, Closure $next)
    {
        // Guard against cases where the session is not started yet.
        $locale = config('app.locale', 'en');

        if (method_exists($request, 'hasSession') && $request->hasSession()) {
            $locale = (string) $request->session()->get('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}

