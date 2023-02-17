<?php

return [
    'generate-meta-description' => [
        'path' => '/generate/meta-description',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateMetaDescriptionAction'
    ],
    'generate-keywords' => [
        'path' => '/generate/keywords',
        'target' => \Passionweb\AiSeoHelper\Controller\Ajax\AiController::class . '::generateKeywordsAction'
    ],
];
