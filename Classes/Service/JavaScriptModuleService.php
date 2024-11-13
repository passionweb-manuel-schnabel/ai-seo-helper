<?php

namespace Passionweb\AiSeoHelper\Service;

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class JavaScriptModuleService
{
    public function addModules(): array
    {
        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() > 11) {
            $resultArray['javaScriptModules'] = [
                JavaScriptModuleInstruction::create('@passionweb/ai-seo-helper/Helper/generate-suggestions.js'),
            ];
            if(ExtensionManagementUtility::isLoaded('news')) {
                $resultArray['javaScriptModules'][] = JavaScriptModuleInstruction::create('@passionweb/ai-seo-helper/Helper/news-generate-suggestions.js');
            }
        } else {
            $resultArray['requireJsModules'] = [
                JavaScriptModuleInstruction::forRequireJS('TYPO3/CMS/AiSeoHelper/Helper/GenerateSuggestions')
            ];
            if(ExtensionManagementUtility::isLoaded('news')) {
                $resultArray['requireJsModules'][] = JavaScriptModuleInstruction::forRequireJS('TYPO3/CMS/AiSeoHelper/Helper/NewsGenerateSuggestions');
            }
        }
        return $resultArray;
    }
}
