<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Log\LogManager;
use Psr\Log\LoggerInterface;
use Passionweb\AiSeoHelper\Service\ContentService;
use Passionweb\AiSeoHelper\Factory\CustomLanguageFactory;
use Passionweb\AiSeoHelper\Factory\SelectedModelFactory;
use Passionweb\AiSeoHelper\Controller\Ajax\AiController;
use Passionweb\AiSeoHelper\EventListener\AfterFormEnginePageInitializedEventListener;
use TYPO3\CMS\Backend\Controller\Event\AfterFormEnginePageInitializedEvent;

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
        ->factory([new ReferenceConfigurator(ExtensionConfiguration::class), 'get'])
        ->args([
            'ai_seo_helper'
        ]);

    $services->set('CustomLanguageArray', 'array')
        ->factory([new ReferenceConfigurator(CustomLanguageFactory::class), 'getCustomLanguages']);

    $services->set('SelectedModel', 'bool')
        ->factory([new ReferenceConfigurator(SelectedModelFactory::class), 'checkSelectedModel'])
        ->arg('$extConf', new ReferenceConfigurator('ExtConf.aiSeoHelper'));

    $containerBuilder->register('Logger', LoggerInterface::class);
    $services->set('PsrLogInterface', 'Logger')
        ->factory([
            new ReferenceConfigurator(LogManager::class), 'getLogger'
        ]);

    $services->set(ContentService::class)
        ->arg('$languages', new ReferenceConfigurator('CustomLanguageArray'))
        ->arg('$nonLegacyModel', new ReferenceConfigurator('SelectedModel'))
        ->arg('$extConf', new ReferenceConfigurator('ExtConf.aiSeoHelper'));

    $services->set(AiController::class)
        ->arg('$contentService', new ReferenceConfigurator(ContentService::class))
        ->arg('$logger', new ReferenceConfigurator('PsrLogInterface'))
        ->public();

    $services->set('AfterFormEnginePageInitializedEventListener', AfterFormEnginePageInitializedEventListener::class)
        ->tag('event.listener', [
            'method' => 'onPagePropertiesLoad',
            'event' => AfterFormEnginePageInitializedEvent::class,
        ]);
};
