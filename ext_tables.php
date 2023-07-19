<?php

defined('TYPO3') or die();

$pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
if(new \TYPO3\CMS\Core\Information\Typo3Version() < 12 && empty($pageRenderer->getCharSet())) {
    $pageRenderer->setCharSet('utf-8');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_aiseohelper_domain_model_customlanguage');
