<?php

declare(strict_types=1);

defined('TYPO3') or die();

$GLOBALS['TBE_STYLES']['skins']['ai_seo_helper']['stylesheetDirectories']['css'] = 'EXT:ai_seo_helper/Resources/Public/Css/';

$pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
$pageRenderer->addInlineLanguageLabelFile('EXT:ai_seo_helper/Resources/Private/Language/backend.xlf');
