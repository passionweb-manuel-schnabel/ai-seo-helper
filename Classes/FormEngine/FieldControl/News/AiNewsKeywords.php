<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\FormEngine\FieldControl\News;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class AiNewsKeywords extends AbstractNode
{
    public function render(): array
    {
        $resultArray = [
            'iconIdentifier' => 'actions-document-synchronize',
            'title' => LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.generation.newsKeywords'),
            'linkAttributes' => [
                'id' => 'generateNewsKeywords',
                'data-news-id' => $this->data['databaseRow']['uid'],
                'data-folder-id' => $this->data['databaseRow']['pid'],
                'data-field-name' => 'keywords'
            ]
        ];

        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() === 12) {
            $resultArray['javaScriptModules'] = [
                JavaScriptModuleInstruction::create('@passionweb/ai-seo-helper/generate-news-keywords.js')
            ];
        } elseif ($typo3Version->getMajorVersion() === 11) {
            $resultArray['requireJsModules'] = [
                JavaScriptModuleInstruction::forRequireJS('TYPO3/CMS/AiSeoHelper/GenerateNewsKeywords')
            ];
        } else {
            $resultArray['requireJsModules'] = [
                'TYPO3/CMS/AiSeoHelper/GenerateNewsKeywords'
            ];
        }

        return $resultArray;
    }
}
