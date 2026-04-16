<?php

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        'defaults' => [
            'title' => 'Hechizos de Maria - Tarot, rituales y magia blanca',
            'titleBefore' => false,
            'description' => 'Lecturas de tarot, rituales personalizados de alta magia y tienda magica con perfumes arabes, amuletos y cuarzos. Por Maria Jose Gomez, tarotista profesional.',
            'separator' => ' | ',
            'keywords' => ['tarot', 'rituales', 'magia blanca', 'amuletos', 'perfumes arabes', 'hechizos', 'Maria Jose'],
            'canonical' => 'full',
            'robots' => 'index, follow',
        ],
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'pinterest' => null,
        ],
        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title' => 'Hechizos de Maria',
            'description' => 'Tarot, rituales y magia blanca con Maria Jose Gomez.',
            'url' => null,
            'type' => 'website',
            'site_name' => 'Hechizos de Maria',
            'locale' => 'es_ES',
            'images' => [],
        ],
    ],
    'twitter' => [
        'defaults' => [
            'card' => 'summary_large_image',
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title' => 'Hechizos de Maria',
            'description' => 'Tarot, rituales y magia blanca',
            'url' => null,
            'type' => 'LocalBusiness',
            'images' => [],
        ],
    ],
];
