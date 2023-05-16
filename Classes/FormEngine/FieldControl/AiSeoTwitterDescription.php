<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\FormEngine\FieldControl;

use Passionweb\AiSeoHelper\Service\JavaScriptModuleService;
use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class AiSeoTwitterDescription extends AbstractNode
{
    public function render(): array
    {
        $resultArray = [
            'iconIdentifier' => 'actions-document-synchronize',
            'title' => LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.generation.twitterDescriptionSuggestions'),
            'linkAttributes' => [
                'id' => 'twitter_description_generation',
                'class' => 'ai-seo-helper-suggestions-generation-btn',
                'data-page-id' => $this->data['databaseRow']['uid'],
                'data-field-name' => 'twitter_description'
            ]
        ];

        $javaScriptModuleService = GeneralUtility::makeInstance(JavaScriptModuleService::class);

        return array_merge($resultArray, $javaScriptModuleService->addModules());
    }
}
