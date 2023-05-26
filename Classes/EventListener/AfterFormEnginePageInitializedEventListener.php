<?php

namespace Passionweb\AiSeoHelper\EventListener;


use TYPO3\CMS\Backend\Controller\Event\AfterFormEnginePageInitializedEvent;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AfterFormEnginePageInitializedEventListener
{
    public function onPagePropertiesLoad(AfterFormEnginePageInitializedEvent $event): void
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addInlineLanguageLabelFile('EXT:ai_seo_helper/Resources/Private/Language/backend.xlf');
    }
}
