<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

$pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
$typo3Version = GeneralUtility::makeInstance(Typo3Version::class);
if ($typo3Version->getVersion() < 12 && empty($pageRenderer->getCharSet())) {
    $pageRenderer->setCharSet('utf-8');
}

ExtensionManagementUtility::allowTableOnStandardPages('tx_aiseohelper_domain_model_customlanguage');
