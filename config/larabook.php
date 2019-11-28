<?php

return [
    'route' => '/larabook',

    'middlewares' => [],

    'docs' => [
        // Storage path of docs files.
        'path'            => '/resources/larabook',

        // Index page file.
        'index'           => 'index.md',

        // Homepage
        'home'            => 'overview.md',

        // Versions
        'versions'        => [
            '1.0',
        ],
        'default_version' => '1.0',

        // Docs repository
        'repository'      => [
            // 'provider' => 'github',
            // 'url' => 'https://github.com/xuejd3/larabook',
        ],
    ],

    // UI settings
    'ui'   => [
        'logo'      => '', // vendor/larabook/images/logo.png
        'nav-links' => [
            //  [
            //      'url' => '/',
            //      'label' => 'Home',
            //      'target' => '_self',
            //  ],
        ],
    ],

    // SEO configs
    'seo'  => [
        'author'      => 'LaraBook',
        'description' => '',
        'keywords'    => '',
        'og'          => [
            'title'       => '',
            'type'        => 'article',
            'url'         => '',
            'image'       => '',
            'description' => '',
        ],
    ],

    'plugins' => [
        'google-analytics' => [
            // 'id' => 'UA-XXXXXXXX-1'
        ],

        // Algolia Docsearch
        'docsearch'        => [
            // 'api_key' => '',
            // 'index_name' => '',
            // 'placeholder' => 'Search',
        ],
    ],

    'date' => [
        'format'   => 'Y-m-d H:i:s',
        'timezone' => 'UTC', // Asia/Shanghai
    ],

    'cache' => [
        'ttl' => env('LARABOOK_CACHE_TTL', 300), // seconds
    ],
];
