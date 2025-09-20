<?php

// app/Http/Middleware/SetLocale.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Apply locale from session or cookie to the application.
     * Must run after StartSession (web group).
     */
    public function handle(Request $request, Closure $next)
    {
        // Default from config
        $locale = (string) config('app.locale', 'en');

        // Prefer session when available
        if (method_exists($request, 'hasSession') && $request->hasSession()) {
            $fromSession = (string) $request->session()->get('locale', '');
            if ($fromSession !== '') {
                $locale = $fromSession;
            }
        }

        // Fallback to cookie when session is unavailable or empty
        if ($locale === '') {
            $fromCookie = (string) $request->cookie('locale', '');
            if ($fromCookie !== '') {
                $locale = $fromCookie;
                // Optionally backfill session for later usage
                if ($request->hasSession()) {
                    $request->session()->put('locale', $locale);
                }
            } else {
                $locale = 'en';
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}

