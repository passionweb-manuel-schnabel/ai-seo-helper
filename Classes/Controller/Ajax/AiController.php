<?php

declare(strict_types=1);

namespace Passionweb\AiSeoHelper\Controller\Ajax;

use Passionweb\AiSeoHelper\Service\ContentService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\Response;

class AiController
{
    private ContentService $contentService;
    public function __construct(ContentService $contentService) {
        $this->contentService = $contentService;
    }

    public function generateMetaDescriptionAction(ServerRequestInterface $request): ResponseInterface
    {
        $postParams = $request->getParsedBody();

        $pageId = (int)$postParams['pageId'];

        $response = new Response();

        if (empty($pageId)) {
            $response->getBody()->write(json_encode(['success' => false]));
            return $response;
        }

        $generatedContent = $this->contentService->getContentFromAi($request, 'openAiPromptPrefixMetaDescription', 'replaceTextMetaDescription');

        $response->getBody()->write(json_encode(['success' => true, 'output' => $generatedContent]));
        return $response;
    }

    public function generateKeywordsAction(ServerRequestInterface $request): ResponseInterface
    {
        $postParams = $request->getParsedBody();

        $pageId = (int)$postParams['pageId'];

        $response = new Response();

        if (empty($pageId)) {
            $response->getBody()->write(json_encode(['success' => false]));
            return $response;
        }

        $generatedContent = $this->contentService->getContentFromAi($request, 'openAiPromptPrefixKeywords', 'replaceTextKeywords');

        $response->getBody()->write(json_encode(['success' => true, 'output' => $generatedContent]));
        return $response;
    }
}
