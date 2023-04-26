<?php

namespace Passionweb\AiSeoHelper\Service;

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

class JavaScriptModuleService
{
    public function addModules(): array
    {
        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() === 12) {
            $resultArray['javaScriptModules'] = [
                JavaScriptModuleInstruction::create('@passionweb/ai-seo-helper/Helper/generate-suggestions.js'),
            ];
        } elseif ($typo3Version->getMajorVersion() === 11) {
            $resultArray['requireJsModules'] = [
                JavaScriptModuleInstruction::forRequireJS('TYPO3/CMS/AiSeoHelper/Helper/GenerateSuggestions')
            ];
        } else {
            $resultArray['requireJsModules'] = [
                'TYPO3/CMS/AiSeoHelper/Helper/GenerateSuggestions'
            ];
        }
        return $resultArray;
    }
}
