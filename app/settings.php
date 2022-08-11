<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'app' => [
                    'APP_NAME'  => $_ENV['APP_NAME'],
                    'APP_URL'   => $_ENV['APP_URL'],
                    'APP_ENV'   => $_ENV['APP_ENV'],
                ],
                'path' => [
                    'database' => __DIR__ . '/../database',
                    'public' => __DIR__ . '/../public',
                    'src' => __DIR__ . '/../src',
                    'data' => __DIR__ . '/../data',
                ],
                'displayErrorDetails' => !empty($_ENV['DISPLAY_ERROR']),
                'logError'            => !empty($_ENV['ERROR_LOGGING']),
                'logErrorDetails'     => !empty($_ENV['ERROR_LOGGING_DETAILS']),
                'logger' => [
                    'name' => 'hayaoki-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
            ]);
        }
    ]);
};
