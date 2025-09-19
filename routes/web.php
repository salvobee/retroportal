<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;

// Theme switch (already discussed)
Route::get('/theme/{mode}', [ThemeController::class, 'set'])
    ->whereIn('mode', ['light','dark'])
    ->name('theme.set');

Route::get('/lang/{locale}', [LanguageController::class, 'set'])
    ->where('locale', '[a-zA-Z_-]+')
    ->name('lang.set');

