<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherDailyLimit
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        $hasPersonalKey = $user->apiKeys()
            ->where('type', 'openweathermap')
            ->whereNotNull('key')
            ->exists();

        if ($hasPersonalKey) {
            return $next($request);
        }

        $limit = (int) config('services.openweather.system_daily_limit', 10);

        if ($limit <= 0) {
            return $next($request);
        }

        $cacheKey = "weather_limit:{$user->id}:" . now()->toDateString();
        $used = (int) Cache::get($cacheKey, 0);

        if ($used >= $limit) {
            return response()->view('pages.weather.limited', [], 429);
        }

        Cache::put($cacheKey, $used + 1, now()->endOfDay());

        return $next($request);
    }
}
