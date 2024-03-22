<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'AI SEO-Helper',
    'description' => 'Generates SEO metadata based on content using AI. Currently several metadata for pages and articles of EXT:news can be generated using an additional button next to the corresponding input fields.',
    'category' => 'be',
    'author' => 'Manuel Schnabel',
    'author_email' => 'service@passionweb.de',
    'author_company' => 'PassionWeb Manuel Schnabel',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '0.6.2',
    'constraints' => [
        'depends' => ['typo3' => '10.4.0-12.4.99'],
        'conflicts' => [],
        'suggests' => [],
    ],
];
