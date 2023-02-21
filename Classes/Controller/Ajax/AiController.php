<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\Controller\Ajax;

use GuzzleHttp\Exception\GuzzleException;
use Passionweb\AiSeoHelper\Service\ContentService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class AiController
{
    private ContentService $contentService;

    private LoggerInterface $logger;

    public function __construct(ContentService $contentService, LoggerInterface $logger) {
        $this->contentService = $contentService;
        $this->logger = $logger;
    }

    public function generateMetaDescriptionAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->generateResponse($request,'openAiPromptPrefixMetaDescription', 'replaceTextMetaDescription');
    }

    public function generateKeywordsAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->generateResponse($request,'openAiPromptPrefixKeywords', 'replaceTextKeywords');
    }

    public function generatePageTitleAction(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        try {
            $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
            $standaloneView->setTemplateRootPaths(['EXT:ai_seo_helper/Resources/Private/Templates/Ajax/Ai/']);
            $standaloneView->getRenderingContext()->setControllerName('Ai');
            $standaloneView->setTemplate('GeneratePageTitle');

            $generatedPageTitleContent = $this->contentService->getContentFromAi($request, 'openAiPromptPrefixPageTitle');

            $suggestions = explode(PHP_EOL, $generatedPageTitleContent);
            $pageTitleSuggestions = [];
            foreach ($suggestions as $suggestion) {
                if(!empty($suggestion) && strpos($suggestion, '-') !== false) {
                    $pageTitleSuggestions[] = ltrim(str_replace('-', '', $suggestion));
                }
            }

            $standaloneView->assign('pageTitleSuggestions', $pageTitleSuggestions);
            $content = $standaloneView->render();

            $response->getBody()->write(json_encode(['success' => true, 'output' => $content]));
            return $response;
        } catch(GuzzleException $e) {
            $this->logger->error($e->getMessage());
            $response->withStatus(400);
            $response->getBody()->write(json_encode(['success' => false, 'error' => $e->getMessage()]));
        } catch(Exception $e) {
            $this->logger->error($e->getMessage());
            $response->withStatus(500);
            $response->getBody()->write(json_encode(['success' => false, 'error' => $e->getMessage()]));
        }
        return $response;
    }

    private function generateResponse(ServerRequestInterface $request, string $extConfPrompt, string $extConfReplaceText): ResponseInterface {
        $response = new Response();
        try {
            $postParams = $request->getParsedBody();
            $pageId = (int)$postParams['pageId'];

            if (empty($pageId)) {
                throw new Exception(LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.noSuitablePage'));
            }

            $generatedContent = $this->contentService->getContentFromAi($request, $extConfPrompt, $extConfReplaceText);

            $response->getBody()->write(json_encode(['success' => true, 'output' => $generatedContent]));
            return $response;
        } catch(GuzzleException $e) {
            $this->logger->error($e->getMessage());
            $response->withStatus(400);
            $response->getBody()->write(json_encode(['success' => false, 'error' => $e->getMessage()]));
        } catch(Exception $e) {
            $this->logger->error($e->getMessage());
            $response->withStatus(500);
            $response->getBody()->write(json_encode(['success' => false, 'error' => $e->getMessage()]));
        }
        return $response;
    }
}
