<?php

if(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('news')) {
    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['description']['config'] = array_merge_recursive(
        $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['description']['config'],
        [
            'fieldControl' => [
                'importControl' => [
                    'renderType' => 'aiNewsMetaDescription'
                ]
            ]
        ]
    );

    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['alternative_title']['config'] = array_merge_recursive(
        $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['alternative_title']['config'],
        [
            'fieldControl' => [
                'importControl' => [
                    'renderType' => 'aiNewsAlternativeTitle'
                ]
            ]
        ]
    );

    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['keywords']['config'] = array_merge_recursive(
        $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['keywords']['config'],
        [
            'fieldControl' => [
                'importControl' => [
                    'renderType' => 'aiNewsKeywords'
                ]
            ]
        ]
    );
}
