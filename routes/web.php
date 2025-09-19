<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RetroPortalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;

// Theme switch (already discussed)
Route::get('/theme/{mode}', [ThemeController::class, 'set'])
    ->whereIn('mode', ['light','dark'])
    ->name('theme.set');

Route::get('/lang/{locale}', [LanguageController::class, 'set'])
    ->where('locale', '[a-zA-Z_-]+')
    ->name('lang.set');

// Home Page
Route::view('/','pages.home')->name('home');

// Retro portal: immediate focus features
Route::get('/search',          [RetroPortalController::class, 'search'])->name('search');
Route::get('/news',            [RetroPortalController::class, 'news'])->name('news');
Route::get('/weather',         [RetroPortalController::class, 'weather'])->name('weather');
Route::get('/wikipedia',       [RetroPortalController::class, 'wikipedia'])->name('wikipedia');
Route::get('/email',           [RetroPortalController::class, 'email'])->name('email');
