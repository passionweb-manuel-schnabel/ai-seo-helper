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
