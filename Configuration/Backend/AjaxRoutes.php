<?php

return [
    'description_generation' => [
        'path' => '/generate/meta-description',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateMetaDescriptionAction'
    ],
    'keywords_generation' => [
        'path' => '/generate/keywords',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateKeywordsAction'
    ],
    'seo_title_generation' => [
        'path' => '/generate/page-title',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generatePageTitleAction'
    ],
    'og_title_generation' => [
        'path' => '/generate/og-title',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateOgTitleAction'
    ],
    'twitter_title_generation' => [
        'path' => '/generate/twitter-title',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateTwitterTitleAction'
    ],
    'og_description_generation' => [
        'path' => '/generate/og-description',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateOgDescriptionAction'
    ],
    'twitter_description_generation' => [
        'path' => '/generate/twitter-description',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateTwitterDescriptionAction'
    ],
];
