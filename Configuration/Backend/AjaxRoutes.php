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
    'abstract_generation' => [
        'path' => '/generate/abstract',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateAbstractAction'
    ],
    'news_description_generation' => [
        'path' => '/generate/news-meta-description',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateNewsMetaDescriptionAction'
    ],
    'news_alternative_title_generation' => [
        'path' => '/generate/news-alternative-title',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateNewsAlternativeTitleAction'
    ],
    'news_keywords_generation' => [
        'path' => '/generate/news-keywords',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateNewsKeywordsAction'
    ],
];
