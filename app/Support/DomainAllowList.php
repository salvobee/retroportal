<?php

namespace App\Support;

final class DomainAllowList
{
    /** @var string[] */
    private array $allowed;
    private bool $whiteListOnly;

    /**
     * @param string[] $allowed  Elenco domini/suffissi consentiti (lowercase)
     */
    public function __construct(array $allowed, bool $whiteListOnly)
    {
        // normalizza e filtra vuoti
        $this->allowed = array_values(array_filter(array_map('strtolower', $allowed)));
        $this->whiteListOnly = $whiteListOnly;
    }

    /**
     * Ritorna true se l'URL è http/https e il suo host matcha la whitelist.
     */
    public function isAllowedUrl(string $url): bool
    {
        if (!$this->whiteListOnly) return true;

        if (!preg_match('#^https?://#i', $url)) {
            return false; // accettiamo solo http/https
        }

        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        if ($host === '') {
            return false;
        }

        foreach ($this->allowed as $suffix) {
            if ($this->hostMatchesSuffix($host, $suffix)) {
                return true;
            }
        }
        return false;
    }

    private function hostMatchesSuffix(string $host, string $suffix): bool
    {
        $suffix = ltrim(strtolower($suffix));
        return $host === $suffix || str_ends_with($host, '.' . $suffix);
    }
}
