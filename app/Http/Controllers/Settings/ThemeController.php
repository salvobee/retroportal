<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ThemeController extends Controller
{
    public function set(Request $request, string $mode): RedirectResponse
    {
        // Persist in session (for current request cycle)
        $request->session()->put('theme', $mode);

        // Also persist in a cookie for long-term (1 year)
        // Cookie(minutes, path, domain, secure, httpOnly, raw, sameSite)
        $minutes = 60 * 24 * 365;
        $cookie = Cookie::make(
            name: 'theme',
            value: $mode,
            minutes: $minutes,
            path: '/',
            domain: null,
            secure: $request->isSecure(), // true on HTTPS
            httpOnly: true,               // JS not needed to read it; safer
            raw: false,
            sameSite: 'lax'               // best cross-compat for legacy
        );

        return redirect()
            ->back()
            ->with('status', "Theme set to {$mode}")
            ->withCookie($cookie);
    }
}

