<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use UMA\Assignment\Settings\Settings;
use UMA\Assignment\Settings\SettingsInterface;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'di_compilation_path' => __DIR__ . '/../var/cache',
                'display_error_details' => false,
                'log_errors' => true,
                'slim' => [
                    'displayErrorDetails' => true,
                    'logErrors' => true,
                    'logErrorDetails' => true,
                ],
                'doctrine' => [
                    'dev_mode' => true,
                    'cache_dir' => __DIR__ . '/../../var/doctrine',
                    'metadata_dirs' => [__DIR__ . '/../Model'],
                    'connection' => [
                        'driver' => 'pdo_sqlite',
                        'path' => __DIR__ . '/../../var/assignment.sqlite'
                    ]
                ],
            ]);
        }
    ]);
};