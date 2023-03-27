<?php

namespace Passionweb\AiSeoHelper\Service;

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

class JavaScriptModuleService
{
    public function addModules(string $javaScriptModule, string $requireJsModules): array
    {
        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() === 12) {
            $resultArray['javaScriptModules'] = [
                JavaScriptModuleInstruction::create($javaScriptModule)
            ];
        } elseif ($typo3Version->getMajorVersion() === 11) {
            // keep RequireJs for TYPO3 below v12.0
            $resultArray['requireJsModules'] = [
                JavaScriptModuleInstruction::forRequireJS($requireJsModules)
            ];
        } else {
            $resultArray['requireJsModules'] = [
                $requireJsModules
            ];
        }
        return $resultArray;
    }
}
