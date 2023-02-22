<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\Service;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\PreviewUriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ContentService
{
    protected array $extConf;

    protected PageRepository $pageRepository;

    protected ExtensionConfiguration $extensionConfiguration;

    public function __construct(
        PageRepository $pageRepository,
        ExtensionConfiguration $extensionConfiguration
    ) {
        $this->pageRepository = $pageRepository;
        $this->extensionConfiguration = $extensionConfiguration;
        $this->extConf = $this->extensionConfiguration->get('ai_seo_helper');
    }

    public function getContentFromAi(
        ServerRequestInterface $request,
        string $extConfPrompt,
        string $extConfReplaceText = ""
    ) {
        $pageContent = $this->getPageContent($request);
        return $this->requestAi($pageContent, $extConfPrompt, $extConfReplaceText);
    }

    public function getPageContent(ServerRequestInterface $request): string
    {
        $pageId = (int)($request->getParsedBody()['pageId'] ?? 0);

        $page = $this->pageRepository->getPage($pageId);
        $previewUriBuilder = PreviewUriBuilder::create($pageId);
        $previewUri = $previewUriBuilder
            ->withAdditionalQueryParameters($this->getTypeParameterIfSet($pageId) . '&_language=' . $page['sys_language_uid'])
            ->buildUri();

        $previewUrl = $previewUri->getScheme() . '://' . $previewUri->getHost() . $previewUri->getPath();

        return file_get_contents($previewUrl);
    }

    /**
     * @throws GuzzleException
     */
    public function requestAi(string $pageContent, $extConfPromptPrefix, $extConfReplaceText): string {
        $client = new \GuzzleHttp\Client();

        $strippedContent = $this->stripPageContent($pageContent);
        $response = $client->request('POST', 'https://api.openai.com/v1/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->extConf['openAiApiKey']
            ],
            'json' => [
                "model" => $this->extConf['openAiModel'],
                "prompt" => $this->extConf[$extConfPromptPrefix].":\n\n" . $strippedContent,
                "temperature" => (float)$this->extConf['openAiTemperature'],
                "max_tokens" => (int)$this->extConf['openAiMaxTokens'],
                "top_p" => (float)$this->extConf['openAiTopP'],
                "frequency_penalty" => (float)$this->extConf['openAiFrequencyPenalty'],
                "presence_penalty" => (float)$this->extConf['openAiPresencePenalty']
            ],
        ]);

        $resJsonBody = $response->getBody()->getContents();
        $resBody = json_decode($resJsonBody, true);
        $generatedText = $resBody['choices'][0]['text'];
        return ltrim(str_replace($extConfReplaceText, '', $generatedText));
    }

    public function getContentForPageTitleSuggestions(ServerRequestInterface $request): string {
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setTemplateRootPaths(['EXT:ai_seo_helper/Resources/Private/Templates/Ajax/Ai/']);
        $standaloneView->getRenderingContext()->setControllerName('Ai');
        $standaloneView->setTemplate('GeneratePageTitle');

        // $generatedPageTitleContent = $this->getContentFromAi($request, 'openAiPromptPrefixPageTitle');

        $generatedPageTitleContent = 'Suggested Page Titles:

- Projektablauf: Von A bis V
- Erfolgreiche Projekte brauchen einen klaren Ablaufplan
- Ein Schritt nach dem Anderen: Die einzelnen Schritte eines Projekts
- Von der Anfrage bis zur Veröffentlichung - So läuft ein Projekt ab
- Alles was du über den Ablauf eines Projekts wissen musst';

        if($this->extConf['showRawPageTitleSuggestions'] === '1') {
            $standaloneView->assign('pageTitleSuggestions', $generatedPageTitleContent);
            $standaloneView->assign('showRawContent', true);
        } else {
            $standaloneView->assign('pageTitleSuggestions', $this->buildBulletPointList($generatedPageTitleContent));
        }

        return $standaloneView->render();
    }

    protected function getTypeParameterIfSet(int $pageId): string
    {
        $typeParameter = '';
        $typeId = (int)(BackendUtility::getPagesTSconfig($pageId)['mod.']['web_view.']['type'] ?? 0);
        if ($typeId > 0) {
            $typeParameter = '&type=' . $typeId;
        }
        return $typeParameter;
    }

    protected function stripPageContent(string $pageContent): string {
        if (preg_match('~<body[^>]*>(.*?)</body>~si', $pageContent, $body))
        {
            $pageContent = $body[0];
        }
        $pageContent = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $pageContent);
        $pageContent = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $pageContent);
        $pageContent = preg_replace('#<footer(.*?)>(.*?)</footer>#is', '', $pageContent);
        $pageContent = preg_replace('#<nav(.*?)>(.*?)</nav>#is', '', $pageContent);
        return strip_tags($pageContent);
    }

    protected function buildBulletPointList(string $content): array {
        $suggestions = explode(PHP_EOL, $content);
        $pageTitleSuggestions = [];
        foreach ($suggestions as $suggestion) {
            if(!empty($suggestion) && strpos($suggestion, '-') !== false) {
                $pageTitleSuggestions[] = ltrim(str_replace('-', '', $suggestion));
            }
        }
        return $pageTitleSuggestions;
    }

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
