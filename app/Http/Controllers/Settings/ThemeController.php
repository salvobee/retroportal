<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function set(Request $request, string $mode): RedirectResponse
    {
        $request->session()->put('theme', $mode);
        // torna alla pagina precedente, altrimenti home
        return redirect()->back()->with('status', "Theme set to {$mode}");
    }
}

