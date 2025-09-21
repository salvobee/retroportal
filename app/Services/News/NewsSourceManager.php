<?php

namespace App\Services\News;

use App\Contracts\News\NewsSourceService;
use App\Contracts\News\RssParserService;

class NewsSourceManager implements NewsSourceService
{
    public function __construct(
        private readonly RssParserService $rssParser
    ) {}

    /**
     * @inheritDoc
     */
    public function getSourcesByCategory(string $locale = 'en'): array
    {
        $config = config('news_sources');
        $availableCategories = $config['locale_sources'][$locale] ?? $config['locale_sources']['en'];
        $categoryNames = $config['categories'][$locale] ?? $config['categories']['en'];
        
        $result = [];
        
        foreach ($availableCategories as $categoryKey) {
            if (!isset($config['sources'][$categoryKey])) {
                continue;
            }
            
            $categoryName = $categoryNames[$categoryKey] ?? ucfirst(str_replace('_', ' ', $categoryKey));
            $sources = [];
            
            foreach ($config['sources'][$categoryKey] as $sourceId => $sourceData) {
                // Filter sources by language preference
                if ($locale === 'it' && $sourceData['language'] === 'en' && $categoryKey !== 'technology' && $categoryKey !== 'science' && $categoryKey !== 'retro_computing') {
                    continue;
                }
                
                $sources[] = array_merge($sourceData, ['id' => $sourceId]);
            }
            
            if (!empty($sources)) {
                $result[$categoryName] = $sources;
            }
        }
        
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getSource(string $sourceId): ?array
    {
        $config = config('news_sources.sources');
        
        foreach ($config as $categoryKey => $sources) {
            if (isset($sources[$sourceId])) {
                return array_merge($sources[$sourceId], [
                    'id' => $sourceId,
                    'category' => $categoryKey
                ]);
            }
        }
        
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getArticles(string $sourceId, int $limit = 20): array
    {
        $source = $this->getSource($sourceId);
        
        if (!$source || !$source['rss_url']) {
            return [];
        }
        
        $articles = $this->rssParser->parseRssFeed($source['rss_url'], $limit);
        
        // Add source name to each article
        return array_map(function ($article) use ($source) {
            return array_merge($article, [
                'source_name' => $source['name']
            ]);
        }, $articles);
    }
}