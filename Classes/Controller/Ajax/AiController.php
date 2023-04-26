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
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class AiController
{
    protected ContentService $contentService;

    protected LoggerInterface $logger;

    public function __construct(ContentService $contentService, LoggerInterface $logger)
    {
        $this->contentService = $contentService;
        $this->logger = $logger;
    }

    public function generateMetaDescriptionAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->generateSuggestions($request, 'MetaDescription');
    }

    public function generateKeywordsAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->generateResponse($request, 'openAiPromptPrefixKeywords', 'replaceTextKeywords');
    }

    public function generatePageTitleAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->generateSuggestions($request, 'PageTitle');
    }

    private function generateResponse(ServerRequestInterface $request, string $extConfPrompt, string $extConfReplaceText): ResponseInterface
    {
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
            $response = $this->logGenerationGuzzleError($e, $response);
        } catch(Exception $e) {
            $this->logger->error($e->getMessage());
            $response->withStatus(400);
            if ($e->getCode() === 1476107295) {
                $response->getBody()->write(json_encode(['success' => false, 'error' => LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.pageNotAccessible')]));
            } else {
                $response->getBody()->write(json_encode(['success' => false, 'error' => $e->getMessage()]));
            }
        }
        return $response;
    }

    private function generateSuggestions(ServerRequestInterface $request, string $type): Response
    {
        $response = new Response();
        try {
            $content = $this->contentService->getContentForSuggestions($request, $type);
            $response->getBody()->write(json_encode(['success' => true, 'output' => $content]));
            return $response;
        } catch (GuzzleException $e) {
            $response = $this->logGuzzleError($e, $response);
        } catch (Exception $e) {
            $response = $this->logError($e, $response);
        }
        return $response;
    }

    private function logGuzzleError(GuzzleException $e, Response $response): Response
    {
        $this->logger->error($e->getMessage());
        $response->withStatus($e->getCode());
        if ($e->getCode() === 500 && strpos($e->getMessage(), 'auth_subrequest_error') !== false) {
            $response->getBody()->write(json_encode(['success' => false, 'error' => LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.apiNotReachable')]));
        } elseif ($e->getCode() === 401 && strpos($e->getMessage(), 'You need to provide your API key') !== false) {
            $response->getBody()->write(json_encode(['success' => false, 'error' => LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.missingApiKey')]));
        } else {
            $response->getBody()->write(json_encode(['success' => false, 'error' => $e->getMessage()]));
        }
        return $response;
    }

    private function logError(Exception $e, Response $response): Response
    {
        $this->logger->error($e->getMessage());
        $response->withStatus(400);
        if ($e->getCode() === 1476107295) {
            $response->getBody()->write(json_encode(['success' => false, 'error' => LocalizationUtility::translate('LLL:EXT:ai_seo_helper/Resources/Private/Language/backend.xlf:AiSeoHelper.pageNotAccessible')]));
        } else {
            $response->getBody()->write(json_encode(['success' => false, 'error' => $e->getMessage()]));
        }
        return $response;
    }
}
