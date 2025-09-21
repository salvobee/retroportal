<?php

use App\Http\Controllers\Features\ChatbotController;
use App\Http\Controllers\Features\ImageProxyController;
use App\Http\Controllers\Features\ProxyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\ThemeController;
use App\Http\Controllers\Settings\LanguageController;
use App\Http\Controllers\Features\WebSearchController;
use App\Http\Controllers\Features\NewsController;
use App\Http\Controllers\Features\WeatherController;
use App\Http\Controllers\Features\EncyclopediaController;

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
Route::get('/wikipedia',    EncyclopediaController::class)
    ->name('features.wikipedia');

Route::prefix('weather')->name('features.weather.')->group(function () {
    Route::get('/', [WeatherController::class, 'form'])->name('form'); // step 1
    Route::get('/search', [WeatherController::class, 'search'])->name('search')->middleware('throttle:weather');
    Route::get('/show', [WeatherController::class, 'show'])->name('show')->middleware('throttle:weather');
});

Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot', [ChatbotController::class, 'send'])->name('chatbot.send');
Route::post('/chatbot/clear', [ChatbotController::class, 'clear'])->name('chatbot.clear');

// Retro Proxy
Route::get('/proxy', ProxyController::class)
    ->name('features.proxy');
Route::get('/proxy/image', ImageProxyController::class)
    ->name('features.proxy.image');
