<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\FormEngine\FieldControl;

use Passionweb\AiSeoHelper\Service\JavaScriptModuleService;
use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class AiSeoMetaDescription extends AbstractNode
{
    public function render(): array
    {
        $resultArray = [
            'iconIdentifier' => 'actions-document-synchronize',
            'title' => LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.generation.metaDescription'),
            'linkAttributes' => [
                'id' => 'generateMetaDescription',
                'data-page-id' => $this->data['databaseRow']['uid'],
                'data-field-name' => 'description'
            ]
        ];

        $javaScriptModuleService = GeneralUtility::makeInstance(JavaScriptModuleService::class);

        return array_merge($resultArray, $javaScriptModuleService->addModules(
            '@passionweb/ai-seo-helper/generate-meta-description.js',
            'TYPO3/CMS/AiSeoHelper/GenerateMetaDescription')
        );
    }
}
