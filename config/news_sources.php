<?php

return [
    /*
    |--------------------------------------------------------------------------
    | News Sources Configuration
    |--------------------------------------------------------------------------
    |
    | Curated list of news sources organized by category and locale.
    | Priority given to sources with RSS feeds for easier parsing.
    | Sources selected for retro computing enthusiasts, tech, science,
    | and general news from authoritative outlets.
    |
    */

    'sources' => [
        // Technology & Computing
        'technology' => [
            'ars_technica' => [
                'name' => 'Ars Technica',
                'description' => 'Technology news and in-depth analysis',
                'url' => 'https://arstechnica.com',
                'rss_url' => 'https://feeds.arstechnica.com/arstechnica/index',
                'language' => 'en',
                'country' => null,
            ],
            'hacker_news' => [
                'name' => 'Hacker News',
                'description' => 'Tech community news and discussions',
                'url' => 'https://news.ycombinator.com',
                'rss_url' => 'https://hnrss.org/frontpage',
                'language' => 'en',
                'country' => null,
            ],
            'the_register' => [
                'name' => 'The Register',
                'description' => 'Enterprise technology news',
                'url' => 'https://www.theregister.com',
                'rss_url' => 'https://www.theregister.com/headlines.atom',
                'language' => 'en',
                'country' => 'GB',
            ],
            'techcrunch' => [
                'name' => 'TechCrunch',
                'description' => 'Startup and technology news',
                'url' => 'https://techcrunch.com',
                'rss_url' => 'https://techcrunch.com/feed/',
                'language' => 'en',
                'country' => 'US',
            ],
        ],

        // Science & Research
        'science' => [
            'nature_news' => [
                'name' => 'Nature News',
                'description' => 'Latest scientific research and discoveries',
                'url' => 'https://www.nature.com/news',
                'rss_url' => 'https://www.nature.com/nature.rss',
                'language' => 'en',
                'country' => null,
            ],
            'science_daily' => [
                'name' => 'ScienceDaily',
                'description' => 'Science news and research summaries',
                'url' => 'https://www.sciencedaily.com',
                'rss_url' => 'https://www.sciencedaily.com/rss/all.xml',
                'language' => 'en',
                'country' => null,
            ],
            'new_scientist' => [
                'name' => 'New Scientist',
                'description' => 'Science and technology magazine',
                'url' => 'https://www.newscientist.com',
                'rss_url' => 'https://www.newscientist.com/feed/home/',
                'language' => 'en',
                'country' => 'GB',
            ],
        ],

        // General News - International
        'general_international' => [
            'bbc_world' => [
                'name' => 'BBC World News',
                'description' => 'International news from the BBC',
                'url' => 'https://www.bbc.com/news/world',
                'rss_url' => 'https://feeds.bbci.co.uk/news/world/rss.xml',
                'language' => 'en',
                'country' => 'GB',
            ],
            'reuters' => [
                'name' => 'Reuters',
                'description' => 'International news agency',
                'url' => 'https://www.reuters.com',
                'rss_url' => 'https://www.reutersagency.com/feed/?best-topics=business-finance&post_type=best',
                'language' => 'en',
                'country' => null,
            ],
            'ap_news' => [
                'name' => 'Associated Press',
                'description' => 'Global news from AP',
                'url' => 'https://apnews.com',
                'rss_url' => 'https://apnews.com/index.rss',
                'language' => 'en',
                'country' => 'US',
            ],
        ],

        // General News - Italy
        'general_italy' => [
            'ansa' => [
                'name' => 'ANSA',
                'description' => 'Agenzia nazionale stampa associata',
                'url' => 'https://www.ansa.it',
                'rss_url' => 'https://www.ansa.it/sito/notizie/topnews/topnews_rss.xml',
                'language' => 'it',
                'country' => 'IT',
            ],
            'corriere' => [
                'name' => 'Corriere della Sera',
                'description' => 'Quotidiano nazionale italiano',
                'url' => 'https://www.corriere.it',
                'rss_url' => 'https://xml.corriereobjects.it/rss/homepage.xml',
                'language' => 'it',
                'country' => 'IT',
            ],
            'repubblica' => [
                'name' => 'La Repubblica',
                'description' => 'Quotidiano nazionale italiano',
                'url' => 'https://www.repubblica.it',
                'rss_url' => 'https://www.repubblica.it/rss/homepage/rss2.0.xml',
                'language' => 'it',
                'country' => 'IT',
            ],
        ],

        // Culture & Arts
        'culture' => [
            'arts_technica' => [
                'name' => 'Arts & Letters Daily',
                'description' => 'Philosophy, literature, and ideas',
                'url' => 'https://www.aldaily.com',
                'rss_url' => 'https://www.aldaily.com/feed/',
                'language' => 'en',
                'country' => null,
            ],
            'smithsonian' => [
                'name' => 'Smithsonian Magazine',
                'description' => 'History, science, arts, and culture',
                'url' => 'https://www.smithsonianmag.com',
                'rss_url' => 'https://www.smithsonianmag.com/rss/latest_articles/',
                'language' => 'en',
                'country' => 'US',
            ],
        ],

        // Retro Computing & Gaming
        'retro_computing' => [
            'vintage_computing' => [
                'name' => 'Vintage Computing and Gaming',
                'description' => 'Classic computers and retro gaming',
                'url' => 'https://www.vintagecomputing.com',
                'rss_url' => 'https://www.vintagecomputing.com/index.php/feed/',
                'language' => 'en',
                'country' => null,
            ],
            'old_vintage_computing' => [
                'name' => 'Old Vintage Computing Research',
                'description' => 'Historical computing research',
                'url' => 'http://oldvcr.blogspot.com',
                'rss_url' => 'http://oldvcr.blogspot.com/feeds/posts/default',
                'language' => 'en',
                'country' => null,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Category Mappings by Locale
    |--------------------------------------------------------------------------
    |
    | Define which categories are available for each locale and their
    | display names in the respective language.
    |
    */

    'categories' => [
        'en' => [
            'technology' => 'Technology & Computing',
            'science' => 'Science & Research',
            'general_international' => 'International News',
            'culture' => 'Culture & Arts',
            'retro_computing' => 'Retro Computing',
        ],
        'it' => [
            'technology' => 'Tecnologia e Informatica',
            'science' => 'Scienza e Ricerca',
            'general_italy' => 'Notizie Italia',
            'general_international' => 'Notizie Internazionali',
            'culture' => 'Cultura e Arte',
            'retro_computing' => 'Retro Computing',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale-specific Source Filters
    |--------------------------------------------------------------------------
    |
    | Define which sources should be shown for each locale.
    | Sources can appear in multiple locales.
    |
    */

    'locale_sources' => [
        'en' => [
            'technology',
            'science',
            'general_international',
            'culture',
            'retro_computing',
        ],
        'it' => [
            'technology',
            'science',
            'general_italy',
            'general_international',
            'culture',
            'retro_computing',
        ],
    ],
];