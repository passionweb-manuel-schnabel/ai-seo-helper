<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'AI SEO-Helper',
    'description' => 'Generates SEO metadata based on page content using AI.',
    'category' => 'be',
    'author' => 'Manuel Schnabel',
    'author_email' => 'service@passionweb.de',
    'author_company' => 'PassionWeb Manuel Schnabel',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '0.1.1',
    'constraints' => [
        'depends' => ['typo3' => '11.5.0-12.2.0'],
        'conflicts' => [],
        'suggests' => [],
    ],
];
