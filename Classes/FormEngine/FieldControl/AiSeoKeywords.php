<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\FormEngine\FieldControl;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

class AiSeoKeywords extends AbstractNode
{
    public function render(): array
    {
        $resultArray = [
            'iconIdentifier' => 'actions-document-synchronize',
            'title' => 'Generate keywords',
            'linkAttributes' => [
                'id' => 'generateKeywords',
                'data-page-id' => $this->data['databaseRow']['uid'],
                'data-field-name' => 'keywords'
            ]
        ];

        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() > 11) {
            $resultArray['javaScriptModules'] = [
                JavaScriptModuleInstruction::create('@passionweb/ai-seo-helper/generate-keywords.js')
            ];
        } else {
            // keep RequireJs for TYPO3 below v12.0
            $resultArray['requireJsModules'] = [
                JavaScriptModuleInstruction::forRequireJS('TYPO3/CMS/AiSeoHelper/GenerateKeywords')
            ];
        }

        return $resultArray;
    }
}
