<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\Features\ChatbotController;
use App\Http\Controllers\Features\ImageProxyController;
use App\Http\Controllers\Features\ProxyController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\ChatbotDailyLimit;
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
// News routes
Route::prefix('news')->name('features.news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/source/{sourceId}', [NewsController::class, 'source'])->name('source');
});
Route::get('/wikipedia',    EncyclopediaController::class)
    ->name('features.wikipedia');

// Chatbot (solo utenti loggati e verificati)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot', [ChatbotController::class, 'send'])
        ->middleware(ChatbotDailyLimit::class)
        ->name('chatbot.send');
    Route::post('/chatbot/clear', [ChatbotController::class, 'clear'])->name('chatbot.clear');
});

// Meteo (solo utenti loggati e verificati)
Route::prefix('weather')->name('features.weather.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [WeatherController::class, 'form'])->name('form');
    Route::get('/search', [WeatherController::class, 'search'])->name('search')->middleware('throttle:weather');
    Route::get('/show', [WeatherController::class, 'show'])->name('show')->middleware('throttle:weather');
});

// Retro Proxy
Route::get('/proxy', ProxyController::class)
    ->name('features.proxy');
Route::get('/proxy/image', ImageProxyController::class)
    ->name('features.proxy.image');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/api-keys', [ApiKeyController::class, 'update'])->name('api.update');
});


require __DIR__.'/auth.php';
