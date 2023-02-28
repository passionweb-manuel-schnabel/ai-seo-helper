<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\Service;

use GuzzleHttp\Exception\GuzzleException;
use Passionweb\AiSeoHelper\Domain\Repository\CustomLanguageRepository;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Routing\UnableToLinkToPageException;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ContentService
{
    protected array $languages = [
        'en' => 'English',
        'us' => 'English',
        'gb' => 'English',
        'de' => 'German',
        'at' => 'German',
        'ch' => 'German',
        'fr' => 'French',
        'nl' => 'Dutch',
        'be' => 'Belgian',
        'es' => 'Spanish',
        'pl' => 'Polish',
        'cz' => 'Czech',
        'sk' => 'Slovak',
        'si' => 'Slovenian',
        'ro' => 'Romanian',
        'ua' => 'Ukrainian',
        'it' => 'Italian',
        'se' => 'Swedish',
        'no' => 'Norwegian',
        'fi' => 'Finnish',
        'dk' => 'Danish',
        'jp' => 'Japanese',
        'cn' => 'Chinese',
    ];

    protected array $extConf;

    protected PageRepository $pageRepository;
    protected SiteMatcher $siteMatcher;
    protected ExtensionConfiguration $extensionConfiguration;
    protected CustomLanguageRepository $customLanguageRepository;

    /**
     * @throws ExtensionConfigurationPathDoesNotExistException
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     */
    public function __construct(
        PageRepository $pageRepository,
        SiteMatcher $siteMatcher,
        CustomLanguageRepository $customLanguageRepository,
        ExtensionConfiguration $extensionConfiguration
    ) {
        $this->pageRepository = $pageRepository;
        $this->siteMatcher = $siteMatcher;
        $this->customLanguageRepository = $customLanguageRepository;
        $this->extensionConfiguration = $extensionConfiguration;

        $this->extConf = $this->extensionConfiguration->get('ai_seo_helper');
        $this->getCustomLanguages();
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     * @throws UnableToLinkToPageException
     */
    public function getContentFromAi(
        ServerRequestInterface $request,
        string $extConfPrompt,
        string $extConfReplaceText = ""
    ): string
    {
        $pageId = (int)($request->getParsedBody()['pageId'] ?? 0);

        $siteLanguage = $this->getSiteLanguageFromPageId($pageId);
        $previewUrl = $this->getPreviewUrl($pageId, $siteLanguage->getLanguageId());

        $strippedPageContent = $this->stripPageContent($this->fetchContentFromUrl($previewUrl));

        $contentLength = strlen($strippedPageContent);
        if(extension_loaded('mbstring')) {
            $contentLength = mb_strlen($strippedPageContent);
        }

        if($this->extConf['useUrlForRequest'] === '1' || $contentLength > (int)$this->extConf['maxAllowedCharacters']) {
            return $this->requestAi($previewUrl, $extConfPrompt, $extConfReplaceText, $siteLanguage->getTwoLetterIsoCode());
        } else {
            return $this->requestAi($strippedPageContent, $extConfPrompt, $extConfReplaceText);
        }
    }

    /**
     * @throws GuzzleException
     */
    public function requestAi(string $content, $extConfPromptPrefix, $extConfReplaceText, $languageIsoCode = ""): string {

        if(!empty($languageIsoCode)) {
            $prompt = $this->extConf[$extConfPromptPrefix] . ' ' . $content . ' in ' . $this->languages[$languageIsoCode];
        }

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.openai.com/v1/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->extConf['openAiApiKey']
            ],
            'json' => [
                "model" => $this->extConf['openAiModel'],
                "prompt" => $prompt ?? $this->extConf[$extConfPromptPrefix].":\n\n" . $content,
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

        $generatedPageTitleContent = $this->getContentFromAi($request, 'openAiPromptPrefixPageTitle');

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
            if(!empty($suggestion) && (strpos($suggestion, '-') !== false || strpos($suggestion, '•') !== false)) {
                $pageTitleSuggestions[] = ltrim(str_replace(['-', '•'], '', $suggestion));
            }
        }
        return $pageTitleSuggestions;
    }

    protected function getPreviewUrl(int $pageId, int $pageLanguage): string
    {
        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() > 10) {
            $previewUriBuilder = \TYPO3\CMS\Backend\Routing\PreviewUriBuilder::create($pageId);

            $previewUri = $previewUriBuilder
                ->withAdditionalQueryParameters($this->getTypeParameterIfSet($pageId) . '&_language=' . $pageLanguage)
                ->buildUri();

            return $previewUri->getScheme() . '://' . $previewUri->getHost() . $previewUri->getPath();
        } else {
            return BackendUtility::getPreviewUrl($pageId);
        }
    }

    protected function getSiteLanguageFromPageId(int $pageId): SiteLanguage
    {
        $rootLine = BackendUtility::BEgetRootLine($pageId);
        $siteMatcher = GeneralUtility::makeInstance(SiteMatcher::class);
        $site = $siteMatcher->matchByPageId($pageId, $rootLine);
        $page = $this->pageRepository->getPage($pageId);

        return  $site->getLanguageById($page['sys_language_uid']);
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    protected function fetchContentFromUrl(string $previewUrl): string
    {
        $fetchedContent = file_get_contents($previewUrl);
        if($fetchedContent === false) {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $previewUrl);
            $fetchedContent = $response->getBody()->getContents();
        }
        if($fetchedContent === false) {
            throw new Exception(LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.fetchContentFailed'));
        }
        return $fetchedContent;
    }
    protected function getCustomLanguages() {
        $customLanguageEntries = $this->customLanguageRepository->findAll();
        $customLanguages = [];
        foreach($customLanguageEntries as $entry) {
            $customLanguages[$entry->getIsoCode()] = $entry->getSpeech();
        }
        $this->languages = array_merge($this->languages, $customLanguages);
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
