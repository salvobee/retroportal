<?php

// app/Http/Controllers/LanguageController.php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /** Allowed locales for this app. Adjust as needed. */
    private array $allowed = ['en', 'it'];

    public function set(Request $request, string $locale): RedirectResponse
    {
        // Normalize and validate
        $locale = strtolower(substr($locale, 0, 5));
        if (!in_array($locale, $this->allowed, true)) {
            $locale = config('app.locale', 'en');
        }

        // Persist in session
        $request->session()->put('locale', $locale);

        // Redirect back (fallback home)
        return redirect()->back();
    }
}

