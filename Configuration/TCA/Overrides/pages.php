<?php

$GLOBALS['TCA']['pages']['columns']['description']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['description']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoMetaDescription'
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['columns']['keywords']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['keywords']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoKeywords'
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['columns']['seo_title']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['seo_title']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoPageTitle'
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['columns']['og_title']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['og_title']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoOpenGraphTitle'
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['columns']['twitter_title']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['twitter_title']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoTwitterTitle'
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['columns']['og_description']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['og_description']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoOpenGraphDescription'
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['columns']['twitter_description']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['twitter_description']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoTwitterDescription'
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['columns']['abstract']['config'] = array_merge_recursive(
    $GLOBALS['TCA']['pages']['columns']['abstract']['config'],
    [
        'fieldControl' => [
            'importControl' => [
                'renderType' => 'aiSeoAbstract'
            ]
        ]
    ]
);
