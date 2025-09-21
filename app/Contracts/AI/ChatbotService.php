<?php

declare(strict_types=1);

namespace App\Contracts\AI;

/**
 * ChatbotService
 *
 * Contract for a server-side ChatGPT integration used by Retroportal.
 * Implementations MUST be synchronous (no JavaScript/streaming required on the client)
 * and SHOULD provide basic caching to reduce duplicate API calls.
 *
 * Notes:
 * - All methods are expected to be safe to call within a typical Laravel controller action.
 * - Implementations SHOULD throw meaningful exceptions on transport/protocol errors.
 */
interface ChatbotService
{
    /**
     * Ask the assistant a single-turn question and get a plain-text reply.
     *
     * This method is optimized for classic form POST → server render flows
     * and MAY apply a short-lived cache for identical prompts to save tokens.
     *
     * @param  string $message  The end-user message (single turn).
     * @param  array<string,mixed> $options Optional runtime overrides:
     *                                      - 'system' (string): custom system prompt.
     *                                      - 'temperature' (float): 0.0–2.0 sampling temperature.
     *                                      - 'cache_ttl' (int): seconds to cache identical prompts.
     * @return string Plain-text assistant reply suitable for legacy HTML rendering.
     *
     * @throws \RuntimeException If the upstream provider returns an error or the response is invalid.
     */
    public function ask(string $message, array $options = []): string;

    /**
     * Ask the assistant using a minimal conversation history (multi-turn).
     *
     * History uses OpenAI-like roles and MUST be ordered from oldest to newest.
     * Implementations MAY trim/clip the history to respect context window limits.
     *
     * Example item: ['role' => 'user'|'assistant'|'system', 'content' => '...']
     *
     * @param  array<int, array{role: 'system'|'user'|'assistant', content: string}> $history
     *         Ordered conversation turns to provide context.
     * @param  array<string,mixed> $options Same semantics as in ask().
     * @return string Plain-text assistant reply.
     *
     * @throws \RuntimeException If the upstream provider returns an error or the response is invalid.
     */
    public function askWithHistory(array $history, array $options = []): string;

    /**
     * Return the model identifier currently in use (e.g., "gpt-5").
     *
     * Implementations SHOULD reflect any runtime configuration/env overrides.
     *
     * @return string Non-empty model name.
     */
    public function model(): string;

    /**
     * Manually invalidate any cache entry derived from a given user message.
     *
     * This is useful when you want to force a fresh answer for a prompt that was
     * previously cached by the implementation.
     *
     * @param  string $message The original user message whose cache should be invalidated.
     * @return void
     */
    public function forgetCacheFor(string $message): void;
}
