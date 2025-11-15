<?php

declare(strict_types=1);

namespace App\Services\AI;

use App\Contracts\AI\ChatbotService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class OpenAiChatbot implements ChatbotService
{
    /**
     * Ask the assistant a single-turn question and get a plain-text reply.
     *
     * Supported $options:
     * - 'system'    (string) Custom system prompt.
     * - 'cache_ttl' (int)    Seconds to cache identical prompts (default 600).
     */
    public function ask(string $message, array $options = []): string
    {
        $system   = (string)($options['system'] ?? 'You are Retroportal AI assistant.');
        $cacheTtl = is_numeric($options['cache_ttl'] ?? null) ? (int)$options['cache_ttl'] : 600;

        $cacheKey = $this->cacheKey('single', [
            'model'   => $this->model(),
            'system'  => $system,
            'message' => trim($message),
        ]);

        return Cache::remember($cacheKey, now()->addSeconds($cacheTtl), function () use ($options, $message, $system) {
            $payload = [
                'model'    => $this->model(),
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user',   'content' => $message],
                ],
            ];

            return $this->dispatch($payload, $options);
        });
    }

    /**
     * Ask the assistant using a minimal conversation history (multi-turn).
     */
    public function askWithHistory(array $history, array $options = []): string
    {
        $normalized = $this->normalizeHistory($history, $options['system'] ?? null);

        $payload = [
            'model'    => $this->model(),
            'messages' => $normalized,
        ];

        $cacheTtl = $options['cache_ttl'] ?? null;
        if (is_numeric($cacheTtl) && (int)$cacheTtl > 0) {
            $cacheKey = $this->cacheKey('history', [
                'model'    => $this->model(),
                'messages' => $normalized,
            ]);

            return Cache::remember($cacheKey, now()->addSeconds((int)$cacheTtl), function () use ($options, $payload) {
                return $this->dispatch($payload, $options);
            });
        }

        return $this->dispatch($payload, $options);
    }

    /**
     * Return the model identifier currently in use (e.g., "gpt-5").
     */
    public function model(): string
    {
        $model = (string) config('services.openai.model', 'gpt-5');
        if ($model === '') {
            throw new RuntimeException('OpenAI model is not configured.');
        }
        return $model;
    }

    /**
     * Manually invalidate cache entries derived from a given single-turn message.
     */
    public function forgetCacheFor(string $message): void
    {
        $key = $this->cacheKey('single', [
            'model'   => $this->model(),
            'system'  => 'You are Retroportal AI assistant.',
            'message' => trim($message),
        ]);

        Cache::forget($key);
    }

    /**
     * Perform the HTTP request to OpenAI and return the assistant content.
     *
     * Throws RuntimeException with a code that the controller maps to a localized message.
     */
    protected function dispatch(array $payload, array $options = []): string
    {
        try {
            $base_uri = config('services.openai.base_uri');
            $key = $options['api_key'] ?? (string)config('services.openai.key');
            $resp = Http::withToken($key)
                ->timeout(300)
                ->retry(1, 150)
                ->post("$base_uri/chat/completions", $payload);

            if (!$resp->successful()) {
                // Extract structured error if present
                $status  = $resp->status();
                $errId   = (string) ($resp->json('error.id') ?? '');
                $errType = (string) ($resp->json('error.type') ?? '');
                $errMsg  = (string) ($resp->json('error.message') ?? '');
                $snippet = Str::limit($resp->body() ?? '', 500);

                // Log a compact but informative entry
                Log::warning('OpenAI chat API error', [
                    'status'   => $status,
                    'error_id' => $errId,
                    'type'     => $errType,
                    'message'  => $errMsg,
                    'model'    => $payload['model'] ?? null,
                    'snippet'  => $snippet,
                ]);

                // Map HTTP status to a controller-friendly exception code
                throw new RuntimeException(
                    $errMsg !== '' ? $errMsg : 'OpenAI HTTP error',
                    $this->mapStatusToCode($status)
                );
            }

            $content = $resp->json('choices.0.message.content');
            if (!is_string($content) || $content === '') {
                // Log invalid shape for diagnostics
                Log::error('OpenAI chat API invalid response shape', [
                    'model'   => $payload['model'] ?? null,
                    'preview' => Str::limit(json_encode($resp->json()), 500),
                ]);

                throw new RuntimeException('Invalid AI response', 701); // 701 => invalid_response
            }

            return trim($content);
        } catch (Throwable $e) {
            // Network/errors before HTTP response: log and rethrow with a custom code
            Log::error('OpenAI chat request failure', [
                'message' => $e->getMessage(),
                'class'   => get_class($e),
            ]);

            // Preserve code if already mapped, otherwise use 700 => network
            $code = $e->getCode() ?: 700;
            throw new RuntimeException('AI request failed: ' . $e->getMessage(), $code, $e);
        }
    }

    /**
     * Map HTTP status codes to controller-consumed codes.
     */
    protected function mapStatusToCode(int $status): int
    {
        return match ($status) {
            400 => 400, // bad_request
            401 => 401, // unauthorized
            403 => 403, // forbidden
            404 => 404, // not_found
            408 => 408, // timeout
            429 => 429, // too_many_requests
            500 => 500, // server_error
            502, 503 => 503, // unavailable
            504 => 504, // timeout
            default => 500,
        };
    }

    /**
     * Normalize history items and optionally ensure a leading system message.
     */
    protected function normalizeHistory(array $history, ?string $overrideSystem): array
    {
        $out = [];

        if ($overrideSystem !== null && trim($overrideSystem) !== '') {
            $out[] = ['role' => 'system', 'content' => trim((string) $overrideSystem)];
        }

        foreach ($history as $turn) {
            if (!is_array($turn) || !isset($turn['role'], $turn['content'])) {
                continue;
            }

            $role = (string) $turn['role'];
            $content = trim((string) $turn['content']);
            if ($content === '') {
                continue;
            }
            if (!in_array($role, ['system', 'user', 'assistant'], true)) {
                continue;
            }

            if ($overrideSystem !== null && $role === 'system' && empty($out)) {
                continue;
            }

            $out[] = ['role' => $role, 'content' => $content];
        }

        if (empty($out) || $out[0]['role'] !== 'system') {
            array_unshift($out, ['role' => 'system', 'content' => 'You are Retroportal AI assistant.']);
        }

        return $out;
    }

    /**
     * Build a deterministic cache key for a given namespace and payload.
     */
    protected function cacheKey(string $ns, array $data): string
    {
        if (isset($data['messages']) && is_array($data['messages'])) {
            $data['messages'] = array_map(function ($m) {
                return [
                    'role'    => (string)($m['role'] ?? ''),
                    'content' => (string)($m['content'] ?? ''),
                ];
            }, $data['messages']);
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return 'chatbot:' . $ns . ':' . sha1((string) $json);
    }
}
