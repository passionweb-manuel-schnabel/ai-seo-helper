<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\Service;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Routing\UnableToLinkToPageException;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ContentService
{
    protected array $languages;
    protected bool $nonLegacyModel;
    protected array $extConf;

    protected PageRepository $pageRepository;
    protected RequestFactory $requestFactory;
    protected SiteMatcher $siteMatcher;

    public function __construct(
        PageRepository $pageRepository,
        SiteMatcher $siteMatcher,
        RequestFactory $requestFactory,
        array $languages,
        bool $nonLegacyModel,
        array $extConf
    ) {
        $this->pageRepository = $pageRepository;
        $this->siteMatcher = $siteMatcher;
        $this->requestFactory = $requestFactory;
        $this->languages = $languages;
        $this->nonLegacyModel = $nonLegacyModel;
        $this->extConf = $extConf;
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
    ): string {
        $parsedBody = $request->getParsedBody();
        $page = $this->pageRepository->getPage((int)$parsedBody['pageId']);

        if(array_key_exists('newsId', $parsedBody)) {
            $siteLanguage = $this->getSiteLanguageFromPageId((int)$parsedBody['folderId'], $page['sys_language_uid']);
            $strippedNewsContent = $this->stripNewsContent($this->fetchContentOfNewsArticle((int)$parsedBody['newsId'], $siteLanguage->getLanguageId()));
            return $this->requestAi($strippedNewsContent, $extConfPrompt, $extConfReplaceText, $siteLanguage->getTwoLetterIsoCode());
        } else {
            $pageId = (int)$parsedBody['pageId'];
            if($page['is_siteroot'] === 1 && $page['l10n_parent'] > 0) {
                $pageId = $page['l10n_parent'];
            }
            $siteLanguage = $this->getSiteLanguageFromPageId($pageId, $page['sys_language_uid']);
            $previewUrl = $this->getPreviewUrl($pageId, $siteLanguage->getLanguageId());

            $strippedPageContent = $this->stripPageContent($this->fetchContentFromUrl($previewUrl));

            if ($this->extConf['useUrlForRequest'] === '1') {
                return $this->requestAi($previewUrl, $extConfPrompt, $extConfReplaceText, $siteLanguage->getTwoLetterIsoCode());
            } else {
                return $this->requestAi($strippedPageContent, $extConfPrompt, $extConfReplaceText, $siteLanguage->getTwoLetterIsoCode());
            }
        }
    }

    /**
     * @throws GuzzleException
     */
    public function requestAi(string $content, $extConfPromptPrefix, $extConfReplaceText, $languageIsoCode): string
    {
        $jsonContent = [
            "model" => $this->extConf['openAiModel'],
            "temperature" => (float)$this->extConf['openAiTemperature'],
            "max_tokens" => (int)$this->extConf['openAiMaxTokens'],
            "top_p" => (float)$this->extConf['openAiTopP'],
            "frequency_penalty" => (float)$this->extConf['openAiFrequencyPenalty'],
            "presence_penalty" => (float)$this->extConf['openAiPresencePenalty']
        ];

        $this->addModelSpecificPrompt($jsonContent, $content, $extConfPromptPrefix, $languageIsoCode);

        $response = $this->requestFactory->request(
            $this->nonLegacyModel ? 'https://api.openai.com/v1/chat/completions' : 'https://api.openai.com/v1/completions',
            'POST',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->extConf['openAiApiKey']
                ],
                'json' => $jsonContent
            ]
        );

        $resJsonBody = $response->getBody()->getContents();
        $resBody = json_decode($resJsonBody, true);
        $generatedText = $this->nonLegacyModel ? $resBody['choices'][0]['message']['content'] : $resBody['choices'][0]['text'];
        return ltrim(str_replace($extConfReplaceText, '', $generatedText));
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     * @throws UnableToLinkToPageException
     */
    public function getContentForSuggestions(ServerRequestInterface $request, string $type): string
    {
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setTemplateRootPaths(['EXT:ai_seo_helper/Resources/Private/Templates/Ajax/Ai/']);
        $standaloneView->getRenderingContext()->setControllerName('Ai');
        $standaloneView->setTemplate('GenerateSuggestions');

        $generatedContent = $this->getContentFromAi($request, 'openAiPromptPrefix' . $type);

        if ($this->extConf['showRaw' . $type . 'Suggestions'] === '1') {
            $standaloneView->assign('suggestions', $generatedContent);
            $standaloneView->assign('showRawContent', true);
        } else {
            $standaloneView->assign('suggestions', $this->buildBulletPointList($generatedContent));
        }

        return $standaloneView->render();
    }

    public function checkUseForAdditionalFields(string $type): bool
    {
        if($type !== 'PageTitle' && $type !== 'MetaDescription') {
            return false;
        }
        return (bool)$this->extConf[lcfirst($type) . 'ForOgAndTwitter'];
    }

    protected function stripPageContent(string $pageContent): string
    {
        if (preg_match('~<body[^>]*>(.*?)</body>~si', $pageContent, $body)) {
            $pageContent = $body[0];
        }
        $pageContent = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $pageContent);
        $pageContent = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $pageContent);
        $pageContent = preg_replace('#<footer(.*?)>(.*?)</footer>#is', '', $pageContent);
        $pageContent = preg_replace('#<nav(.*?)>(.*?)</nav>#is', '', $pageContent);
        return strip_tags($pageContent);
    }

    protected function stripNewsContent(string $newsContent): string
    {
        if (preg_match('~<body[^>]*>(.*?)</body>~si', $newsContent, $body)) {
            $newsContent = $body[0];
        }
        $newsContent = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $newsContent);
        $newsContent = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $newsContent);
        $newsContent = preg_replace('#<header(.*?)>(.*?)</header>#is', '', $newsContent);
        $newsContent = preg_replace('#<footer(.*?)>(.*?)</footer>#is', '', $newsContent);
        $newsContent = preg_replace('#<nav(.*?)>(.*?)</nav>#is', '', $newsContent);

        return strip_tags($newsContent);
    }

    protected function buildBulletPointList(string $content): array
    {
        $suggestions = explode(PHP_EOL, $content);
        $strippedSuggestions = [];
        foreach ($suggestions as $suggestion) {
            if (!empty($suggestion) && (strpos($suggestion, '-') !== false || strpos($suggestion, '•') !== false)) {
                $strippedSuggestions[] = ltrim(str_replace(['-', '•'], '', $suggestion));
            }
        }
        return $strippedSuggestions;
    }

    /**
     * @throws UnableToLinkToPageException
     */
    protected function getPreviewUrl(int $pageId, int $pageLanguage, array $additionalQueryParameters = []): string
    {
        $additionalGetVars = '_language='.$pageLanguage;
        foreach ($additionalQueryParameters as $key => $value) {
            if(!empty($additionalGetVars)) {
                $additionalGetVars .= '&';
            }
            $additionalGetVars .= $key . '=' . $value;
        }

        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() > 10) {
            $previewUriBuilder = \TYPO3\CMS\Backend\Routing\PreviewUriBuilder::create($pageId);
            $previewUri = $previewUriBuilder
                ->withAdditionalQueryParameters($additionalGetVars)
                ->buildUri();

            if($previewUri === null) {
                throw new UnableToLinkToPageException(LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.unableToLinkToPage', null, [$pageId, $pageLanguage]));
            }
            if($previewUri->getScheme() === "" || $previewUri->getHost() === "") {
                $request = $GLOBALS['TYPO3_REQUEST'];
                $previewUri = $previewUri->withScheme($request->getUri()->getScheme());
                $previewUri = $previewUri->withHost($request->getUri()->getHost());
            }
            if(count($additionalQueryParameters) > 0) {
                return $previewUri->getScheme() . '://' . $previewUri->getHost() . $previewUri->getPath() . '?' . $previewUri->getQuery();
            } else {
                return $previewUri->getScheme() . '://' . $previewUri->getHost() . $previewUri->getPath();
            }
        } else {
            if(count($additionalQueryParameters) > 0) {
                return BackendUtility::getPreviewUrl($pageId, '', null, '', '', $additionalGetVars);
            } else {
                return BackendUtility::getPreviewUrl($pageId);
            }
        }
    }

    /**
     * @throws SiteNotFoundException
     */
    protected function getSiteLanguageFromPageId(int $pageId, int $pageSysLanguageUid): SiteLanguage
    {
        $siteMatcher = GeneralUtility::makeInstance(SiteMatcher::class);
        $rootLine = BackendUtility::BEgetRootLine($pageId);
        $site = $siteMatcher->matchByPageId($pageId, $rootLine);
        return  $site->getLanguageById($pageSysLanguageUid);
    }

    /**
     * @throws Exception
     */
    protected function fetchContentFromUrl(string $previewUrl): string
    {
        try {
            return $this->getContentFromPreviewUrl($previewUrl);
        } catch (GuzzleException $e) {
            $previewUrl = rtrim($previewUrl, '/');
            return $this->getContentFromPreviewUrl($previewUrl);
        }
    }

    /**
     * @throws Exception
     */
    public function getContentFromPreviewUrl(string $previewUrl): string
    {
        $response = $this->requestFactory->request($previewUrl);
        $fetchedContent = $response->getBody()->getContents();

        if (empty($fetchedContent)) {
            throw new Exception(LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.fetchContentFailed'));
        }
        return $fetchedContent;
    }

    /**
     * @throws Exception
     */
    protected function fetchContentOfNewsArticle(int $newsId, int $pageLanaguage): string
    {
        $additionalQueryParameters = [
            'tx_news_pi1[action]' => 'detail',
            'tx_news_pi1[controller]'=> 'News',
            'tx_news_pi1[news]' => $newsId
        ];

        $previewUrl = $this->getPreviewUrl((int)$this->extConf['singleNewsDisplayPage'], $pageLanaguage, $additionalQueryParameters);
        $response = $this->requestFactory->request($previewUrl);
        $fetchedContent = $response->getBody()->getContents();

        if (empty($fetchedContent)) {
            throw new Exception(LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.fetchContentFailed'));
        }
        return $fetchedContent;
    }

    protected function addModelSpecificPrompt(array &$jsonContent, string $content, string $extConfPromptPrefix, string $languageIsoCode)
    {
        if ($this->nonLegacyModel) {
            $jsonContent["messages"][] = [
                'role' => 'user',
                'content' => $this->extConf[$extConfPromptPrefix] . ' \"' . trim($content) . '\" . Return the bullet point list in ' . $this->languages[$languageIsoCode] .'!'
                ];
        } else {
            $jsonContent["prompt"] = $this->extConf[$extConfPromptPrefix]. ' in ' . $this->languages[$languageIsoCode] .":\n\n" . trim($content);
        }
    }
}
