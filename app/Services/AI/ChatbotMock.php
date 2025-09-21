<?php

declare(strict_types=1);

namespace App\Services\AI;

use App\Contracts\ChatbotService;
use RuntimeException;

/**
 * ChatbotMock
 *
 * Lightweight, deterministic mock for ChatbotService.
 * - Never calls external APIs.
 * - Produces fast, token-free answers suitable for tests and local dev.
 * - Supports minimal options to simulate behaviors (latency, failures).
 *
 * Supported $options keys (for ask/askWithHistory):
 * - 'fail'       (bool)  If true, throws a RuntimeException.
 * - 'latency_ms' (int)   If > 0, sleeps for the given milliseconds.
 * - 'system'     (string)Ignored here; accepted for interface parity.
 * - 'temperature'(float)Ignored here; accepted for interface parity.
 * - 'cache_ttl'  (int)   Ignored here; mock does not cache.
 */
class ChatbotMock implements ChatbotService
{
    /**
     * Ask the assistant a single-turn question and get a plain-text reply.
     */
    public function ask(string $message, array $options = []): string
    {
        $this->maybeSleep($options);
        $this->maybeFail($options);

        // Deterministic pseudo-reply based on input length / hash
        $bucket = $this->bucket($message);

        switch ($bucket) {
            case 0:
                return "Mock reply: I received your message: \"{$this->sanitize($message)}\".";
            case 1:
                return "Mock reply: Here is a concise answer for testing purposes.";
            case 2:
                return "Mock reply: This is a deterministic response with no external calls.";
            default:
                return "Mock reply: Everything looks good on my side.";
        }
    }

    /**
     * Ask the assistant using a minimal conversation history (multi-turn).
     * The mock concatenates the last user turn (if any) to simulate context use.
     */
    public function askWithHistory(array $history, array $options = []): string
    {
        $this->maybeSleep($options);
        $this->maybeFail($options);

        $lastUser = $this->lastUserMessage($history);
        if ($lastUser === null) {
            return "Mock reply: No user message found in history.";
        }

        $bucket = $this->bucket($lastUser);

        switch ($bucket) {
            case 0:
                return "Mock reply (with history): You said \"{$this->sanitize($lastUser)}\". Acknowledge.";
            case 1:
                return "Mock reply (with history): Context noted. Proceeding with a safe test answer.";
            case 2:
                return "Mock reply (with history): Deterministic output for repeatable tests.";
            default:
                return "Mock reply (with history): All set.";
        }
    }

    /**
     * Return a stable "model" identifier for the mock.
     */
    public function model(): string
    {
        return 'mock-chatbot';
    }

    /**
     * No-op for the mock since no caching is performed.
     */
    public function forgetCacheFor(string $message): void
    {
        // Intentionally left blank (mock does not cache).
    }

    /**
     * Extract the last user's message from the history, if any.
     */
    protected function lastUserMessage(array $history): ?string
    {
        for ($i = count($history) - 1; $i >= 0; $i--) {
            $turn = $history[$i] ?? null;
            if (is_array($turn) && ($turn['role'] ?? null) === 'user') {
                $content = (string) ($turn['content'] ?? '');
                return trim($content) !== '' ? $content : null;
            }
        }
        return null;
    }

    /**
     * Produce a deterministic small integer bucket for a given string.
     */
    protected function bucket(string $text): int
    {
        // Simple, stable bucketing based on crc32 modulo 4
        return (int) (abs(crc32($text)) % 4);
    }

    /**
     * Simulate latency if requested.
     */
    protected function maybeSleep(array $options): void
    {
        $ms = (int) ($options['latency_ms'] ?? 0);
        if ($ms > 0) {
            usleep($ms * 1000);
        }
    }

    /**
     * Simulate a failure if requested.
     */
    protected function maybeFail(array $options): void
    {
        if (!empty($options['fail'])) {
            throw new RuntimeException('MockChatbot forced failure (options.fail = true).');
        }
    }

    /**
     * Sanitize user-provided echo snippets for display.
     */
    protected function sanitize(string $text): string
    {
        // Minimal sanitization for mock echoing (no HTML context here).
        $t = trim($text);
        $t = preg_replace('/\s+/', ' ', $t);
        return mb_substr($t, 0, 500);
    }
}
