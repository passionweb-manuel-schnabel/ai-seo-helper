<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\Controller\Ajax;

use GuzzleHttp\Exception\GuzzleException;
use Passionweb\AiSeoHelper\Service\ContentService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Http\Response;

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

    private function generateResponse(ServerRequestInterface $request, string $extConfPrompt, string $extConfReplaceText): ResponseInterface {
        $response = new Response();
        try {
            $postParams = $request->getParsedBody();
            $pageId = (int)$postParams['pageId'];

            if (empty($pageId)) {
                throw new Exception('Didn\'t find a suitable page uid.');
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
