<?php

return [
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
            'slashdot' => [
                'name' => 'Slashdot',
                'description' => 'News for nerds, stuff that matters',
                'url' => 'https://slashdot.org',
                'rss_url' => 'http://rss.slashdot.org/Slashdot/slashdotMain',
                'language' => 'en',
                'country' => null,
            ],
            'punto_informatico' => [
                'name' => 'Punto Informatico',
                'description' => 'Tecnologia e innovazione in Italia',
                'url' => 'https://www.punto-informatico.it',
                'rss_url' => 'https://www.punto-informatico.it/feed/',
                'language' => 'it',
                'country' => 'IT',
            ],
            'indie_retro_news' => [
                'name' => 'Indie Retro News',
                'description' => 'Retro computing and indie gaming news',
                'url' => 'https://www.indieretronews.com',
                'rss_url' => 'https://www.indieretronews.com/feeds/posts/default',
                'language' => 'en',
                'country' => null,
            ],
        ],

        // Science & Research
        'science' => [
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
            'post' => [
                'name' => 'Il Post',
                'description' => 'Quotidiano nazionale italiano',
                'url' => 'https://www.ilpost.it',
                'rss_url' => 'https://www.ilpost.it/feed',
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
            'open' => [
                'name' => 'Open',
                'description' => 'Quotidiano online italiano',
                'url' => 'https://www.open.online',
                'rss_url' => 'https://www.open.online/feed',
                'language' => 'it',
                'country' => 'IT',
            ],
            'rai' => [
                'name' => 'Rai News',
                'description' => 'Servizio pubblico italiano',
                'url' => 'https://www.rainews.it',
                'rss_url' => 'https://www.rainews.it/rss',
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

        // Music & Magazines
        'music' => [
            'rolling_stone_it' => [
                'name' => 'Rolling Stone Italia',
                'description' => 'Musica, cultura e spettacolo',
                'url' => 'https://www.rollingstone.it',
                'rss_url' => 'https://www.rollingstone.it/feed/',
                'language' => 'it',
                'country' => 'IT',
            ],
            'rolling_stone' => [
                'name' => 'Rolling Stone',
                'description' => 'International music and pop culture',
                'url' => 'https://www.rollingstone.com',
                'rss_url' => 'https://www.rollingstone.com/music/music-news/feed/',
                'language' => 'en',
                'country' => 'US',
            ],
            'pitchfork' => [
                'name' => 'Pitchfork',
                'description' => 'Music reviews, news and features',
                'url' => 'https://pitchfork.com',
                'rss_url' => 'https://pitchfork.com/rss/news/',
                'language' => 'en',
                'country' => 'US',
            ],
            'soundwall' => [
                'name' => 'Soundwall',
                'description' => 'Musica elettronica italiana',
                'url' => 'https://www.soundwall.it',
                'rss_url' => 'https://www.soundwall.it/feed/',
                'language' => 'it',
                'country' => 'IT',
            ],
            'sound_on_sound' => [
                'name' => 'Sound on Sound',
                'description' => 'Recording technology magazine',
                'url' => 'https://www.soundonsound.com',
                'rss_url' => 'https://www.soundonsound.com/rss/all',
                'language' => 'en',
                'country' => 'GB',
            ],
            'synthtopia' => [
                'name' => 'Synthtopia',
                'description' => 'Synthesizers and electronic music',
                'url' => 'https://www.synthtopia.com',
                'rss_url' => 'https://www.synthtopia.com/feed/',
                'language' => 'en',
                'country' => null,
            ],
            'attack_mag' => [
                'name' => 'Attack Magazine',
                'description' => 'Electronic music production',
                'url' => 'https://www.attackmagazine.com',
                'rss_url' => 'https://www.attackmagazine.com/feed/',
                'language' => 'en',
                'country' => 'GB',
            ],
            'music_radar' => [
                'name' => 'MusicRadar Tech',
                'description' => 'Music tech and gear news',
                'url' => 'https://www.musicradar.com',
                'rss_url' => 'https://www.musicradar.com/rss',
                'language' => 'en',
                'country' => 'GB',
            ],
        ],

        // Linux & Open Source
        'linux_open_source' => [
            'phoronix' => [
                'name' => 'Phoronix',
                'description' => 'Linux hardware and performance news',
                'url' => 'https://www.phoronix.com',
                'rss_url' => 'https://www.phoronix.com/rss.php',
                'language' => 'en',
                'country' => null,
            ],
            'linux_today' => [
                'name' => 'Linux Today',
                'description' => 'Linux news aggregator',
                'url' => 'https://www.linuxtoday.com',
                'rss_url' => 'https://www.linuxtoday.com/feed',
                'language' => 'en',
                'country' => null,
            ],
            'lffl' => [
                'name' => 'LFFL Linux Freedom',
                'description' => 'Linux news in Italian',
                'url' => 'https://www.lffl.org',
                'rss_url' => 'https://feeds.feedburner.com/linuxfreedom',
                'language' => 'it',
                'country' => 'IT',
            ],
        ],

        // Web & Development
        'web_dev' => [
            'laravel_news' => [
                'name' => 'Laravel News',
                'description' => 'Laravel news and tutorials',
                'url' => 'https://laravel-news.com',
                'rss_url' => 'https://laravel-news.com/feed',
                'language' => 'en',
                'country' => null,
            ],
            'smashing_mag' => [
                'name' => 'Smashing Magazine',
                'description' => 'Web design and development',
                'url' => 'https://www.smashingmagazine.com',
                'rss_url' => 'https://www.smashingmagazine.com/feed/',
                'language' => 'en',
                'country' => 'DE',
            ],
        ],
    ],

    'categories' => [
        'en' => [
            'technology' => 'Technology & Computing',
            'science' => 'Science & Research',
            'general_international' => 'International News',
            'culture' => 'Culture & Arts',
            'music' => 'Music & Magazines',
            'linux_open_source' => 'Linux & Open Source',
            'web_dev' => 'Web & Development',
            'retro_computing' => 'Retro Computing',
        ],
        'it' => [
            'technology' => 'Tecnologia e Informatica',
            'science' => 'Scienza e Ricerca',
            'general_italy' => 'Notizie Italia',
            'general_international' => 'Notizie Internazionali',
            'culture' => 'Cultura e Arte',
            'music' => 'Musica e Riviste',
            'linux_open_source' => 'Linux e Open Source',
            'web_dev' => 'Web e Sviluppo',
            'retro_computing' => 'Retro Computing',
        ],
    ],

    'locale_sources' => [
        'en' => [
            'technology',
            'science',
            'general_international',
            'culture',
            'music',
            'linux_open_source',
            'web_dev',
            'retro_computing',
        ],
        'it' => [
            'technology',
            'science',
            'general_italy',
            'general_international',
            'culture',
            'music',
            'linux_open_source',
            'web_dev',
            'retro_computing',
        ],
    ],
];
