<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        ImageAnnotatorClient::class => function (ContainerInterface $c) {
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/../google_ocr_credentials.json');
            $client = new ImageAnnotatorClient([
                'credentials' => __DIR__ . '/../google_ocr_credentials.json',
            ]);
            return $client;
        },
    ]);
};
