<?php

return [
    'dependencies' => ['core', 'backend'],
    'imports' => [
        '@passionweb/ai-seo-helper/' => 'EXT:ai_seo_helper/Resources/Public/JavaScript/',
    ],
//    'imports' => [
//        '@passionweb/ai-seo-helper/' => [
//            'path' => 'EXT:ai_seo_helper/Resources/Public/JavaScript/',
//            'exclude' => [
//                'EXT:ai_seo_helper/Resources/Public/JavaScript/Helper/',
//            ],
//        ],
//        'generateSuggestions' => 'EXT:ai_seo_helper/Resources/Public/JavaScript/Helper/generate-suggestions.js',
//    ],
];
