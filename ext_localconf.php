<?php

defined('TYPO3') or die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410677] = [
    'nodeName' => 'aiSeoMetaDescription',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoMetaDescription::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410678] = [
    'nodeName' => 'aiSeoKeywords',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoKeywords::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410679] = [
    'nodeName' => 'aiSeoPageTitle',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoPageTitle::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410680] = [
    'nodeName' => 'aiSeoOpenGraphTitle',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoOpenGraphTitle::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410681] = [
    'nodeName' => 'aiSeoTwitterTitle',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoTwitterTitle::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410682] = [
    'nodeName' => 'aiSeoOpenGraphDescription',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoOpenGraphDescription::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410683] = [
    'nodeName' => 'aiSeoTwitterDescription',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoTwitterDescription::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410689] = [
    'nodeName' => 'aiSeoAbstract',
    'priority' => 30,
    'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\AiSeoAbstract::class
];

if(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('news')) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410684] = [
        'nodeName' => 'aiNewsMetaDescription',
        'priority' => 30,
        'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\News\AiNewsMetaDescription::class
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410685] = [
        'nodeName' => 'aiNewsAlternativeTitle',
        'priority' => 30,
        'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\News\AiNewsAlternativeTitle::class
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1676410686] = [
        'nodeName' => 'aiNewsKeywords',
        'priority' => 30,
        'class' => \Passionweb\AiSeoHelper\FormEngine\FieldControl\News\AiNewsKeywords::class
    ];
}

