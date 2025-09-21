<?php

namespace App\Providers;

use App\Contracts\ChatbotService;
use App\Services\AI\ChatbotMock;
use App\Services\AI\OpenAiChatbot;
use Illuminate\Support\ServiceProvider;

class ChatbotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind the interface to the OpenAI implementation
        $this->app->bind(ChatbotService::class, OpenAiChatbot::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
