<?php

use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

// Theme switch (already discussed)
Route::get('/theme/{mode}', [ThemeController::class, 'set'])
    ->whereIn('mode', ['light','dark'])
    ->name('theme.set');

