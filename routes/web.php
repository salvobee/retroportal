<?php

use App\Http\Controllers\Features\ImageProxyController;
use App\Http\Controllers\Features\ProxyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\ThemeController;
use App\Http\Controllers\Settings\LanguageController;
use App\Http\Controllers\Features\WebSearchController;
use App\Http\Controllers\Features\NewsController;
use App\Http\Controllers\Features\WeatherController;
use App\Http\Controllers\Features\WikipediaController;

// Settings
Route::get('/theme/{mode}', [ThemeController::class, 'set'])
    ->whereIn('mode', ['light','dark'])
    ->name('settings.theme');

Route::get('/lang/{locale}', [LanguageController::class, 'set'])
    ->where('locale', '[a-zA-Z_-]+')
    ->name('settings.lang');

// Home Page
Route::view('/','pages.home')
    ->name('home');

// Retro Portal Features
Route::get('/search',       WebSearchController::class)
    ->name('features.search');
Route::get('/news',         NewsController::class)
    ->name('features.news');
Route::get('/weather',      WeatherController::class)
    ->name('features.weather');
Route::get('/wikipedia',    WikipediaController::class)
    ->name('features.wikipedia');

// Retro Proxy
Route::get('/proxy', ProxyController::class)
    ->name('features.proxy');
Route::get('/proxy/image', ImageProxyController::class)
    ->name('features.proxy.image');
