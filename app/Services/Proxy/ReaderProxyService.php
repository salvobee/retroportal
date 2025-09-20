<?php

namespace App\Services\Proxy;

use Illuminate\Support\Facades\Cache;

class ReaderProxyService
{
    public function __construct(
        private readonly HtmlFetcher $fetcher,
        private readonly ParserResolver $resolver,
    ) {}

    /**
     * @return array{title:string, body:string}
     */
    public function fetchSimplified(string $url, int $ttlMinutes = 10): array
    {
        $cacheKey = 'reader:' . md5($url);

        return Cache::remember($cacheKey, now()->addMinutes($ttlMinutes), function () use ($url) {
            $result = $this->fetcher->fetch($url);
            if ($result === null) {
                return [
                    'title' => 'Unavailable',
                    'body'  => '<p>Content not available.</p>',
                ];
            }

            $parser = $this->resolver->resolve($result->finalUrl);
            return $parser->parse($result->html, $result->finalUrl);
        });
    }
}
