<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Log\LogManager;
use Psr\Log\LoggerInterface;
use Passionweb\AiSeoHelper\Service\ContentService;
use Passionweb\AiSeoHelper\Factory\CustomLanguageFactory;
use Passionweb\AiSeoHelper\Controller\Ajax\AiController;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    $services->load('Passionweb\\AiSeoHelper\\', __DIR__ . '/../Classes/')
        ->exclude([
            __DIR__ . '/../Classes/Domain/Model',
        ]);

    $services->set('ExtConf.aiSeoHelper', 'array')
        ->factory([service(ExtensionConfiguration::class), 'get'])
        ->args([
            'ai_seo_helper'
        ]);

    $services->set('CustomLanguageArray', 'array')
        ->factory([service(CustomLanguageFactory::class), 'getCustomLanguages']);

    $containerBuilder->register('Logger', LoggerInterface::class);
    $services->set('PsrLogInterface', 'Logger')
        ->factory([
            service(LogManager::class), 'getLogger'
        ]);

    $services->set(ContentService::class)
        ->arg('$languages', service('CustomLanguageArray'))
        ->arg('$extConf', service('ExtConf.aiSeoHelper'));

    $services->set(AiController::class)
        ->arg('$contentService', service(ContentService::class))
        ->arg('$logger', service('PsrLogInterface'))
        ->public();
};
