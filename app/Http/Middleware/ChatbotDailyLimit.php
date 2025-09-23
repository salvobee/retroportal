<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChatbotDailyLimit
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Se l'utente ha una API key valida per OpenAI, bypassa
        $hasOpenAiKey = $user->apiKeys()
            ->where('type', 'openai')
            ->whereNotNull('key')
            ->exists();

        if ($hasOpenAiKey) {
            return $next($request);
        }

        // Identificatore unico per la giornata
        $cacheKey = "chatbot_limit:{$user->id}:" . now()->toDateString();

        // Se ha già consumato la richiesta → errore 429
        if (Cache::has($cacheKey)) {
            return response()->view('errors.chatbot_limit', [], 429);
        }

        // Segna che l'utente ha consumato la richiesta
        Cache::put($cacheKey, true, now()->endOfDay());

        return $next($request);
    }
}
