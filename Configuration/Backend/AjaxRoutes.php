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
];
