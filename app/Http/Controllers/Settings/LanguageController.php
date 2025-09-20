<?php

// app/Http/Controllers/LanguageController.php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /** Allowed locales. */
    private array $allowed = ['en', 'it'];

    public function set(Request $request, string $locale): RedirectResponse
    {
        // Normalize + validate
        $locale = strtolower(substr($locale, 0, 5));
        if (!in_array($locale, $this->allowed, true)) {
            $locale = config('app.locale', 'en');
        }

        // Persist in session
        $request->session()->put('locale', $locale);

        // Also persist in a cookie for long-term (1 year)
        $minutes = 60 * 24 * 365;
        $cookie = cookie(
            name: 'locale',
            value: $locale,
            minutes: $minutes,
            path: '/',
            domain: null,
            secure: $request->isSecure(),
            httpOnly: true,
            raw: false,
            sameSite: 'lax'
        );

        return redirect()->back()->withCookie($cookie);
    }
}

