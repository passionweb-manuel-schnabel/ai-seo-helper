<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\FormEngine\FieldControl;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
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

        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() === 12) {
            $resultArray['javaScriptModules'] = [
                JavaScriptModuleInstruction::create('@passionweb/ai-seo-helper/generate-meta-description.js')
            ];
        } else if($typo3Version->getMajorVersion() === 11) {
            $resultArray['requireJsModules'] = [
                JavaScriptModuleInstruction::forRequireJS('TYPO3/CMS/AiSeoHelper/GenerateMetaDescription')
            ];
        } else {
            $resultArray['requireJsModules'] = [
                'TYPO3/CMS/AiSeoHelper/GenerateMetaDescription'
            ];
        }

        return $resultArray;
    }
}
