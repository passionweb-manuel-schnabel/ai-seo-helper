<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Log\LogManager;

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
        ->args(
            [
                'ai_seo_helper'
            ]
        );

    $containerBuilder->register('Logger', \Psr\Log\LoggerInterface::class);
    $services->set('PsrLogInterface', 'Logger')
        ->factory(
            [
                service(LogManager::class), 'getLogger'
            ]
        );

    $services->set(\Passionweb\AiSeoHelper\Service\ContentService::class)
        ->arg('$extConf', service('ExtConf.aiSeoHelper'))
        ->public();

    $services->set(\Passionweb\AiSeoHelper\Controller\Ajax\AiController::class)
        ->arg('$logger', service('PsrLogInterface'))
        ->public();
};
