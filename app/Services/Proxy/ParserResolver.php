<?php

namespace App\Services\Proxy;

use App\Contracts\ContentParser;
use App\Services\Proxy\Parsers\GenericContentParser;

class ParserResolver
{
    /** @var array<string,string> hostSuffix => FQCN */
    private array $map;

    public function __construct(array $map)
    {
        // normalizza chiavi in lowercase
        $this->map = array_change_key_case($map, CASE_LOWER);
    }

    public function resolve(string $url): ContentParser
    {
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

        foreach ($this->map as $suffix => $class) {
            if ($suffix !== '' && $host !== '' && $this->hostMatchesSuffix($host, $suffix)) {
                return app($class);
            }
        }

        return app(GenericContentParser::class);
    }

    private function hostMatchesSuffix(string $host, string $suffix): bool
    {
        // Match esatto o per suffisso (es. it.wikipedia.org -> wikipedia.org)
        return $host === $suffix || str_ends_with($host, '.' . $suffix);
    }
}
