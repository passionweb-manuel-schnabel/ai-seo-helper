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
