<?php

declare(strict_types=1);

const APP_ROOT = __DIR__;

// settings for development

return [
    'settings' => [
        'slim' => [
            // Returns a detailed HTML page with error details and
            // a stack trace. Should be disabled in production.
            'displayErrorDetails' => true,

            // Whether to display errors on the internal PHP log or not.
            'logErrors' => true,

            // If true, display full errors with message and stack trace on the PHP log.
            // If false, display only "Slim Application Error" on the PHP log.
            // Doesn't do anything when 'logErrors' is false.
            'logErrorDetails' => true,
        ],

        'doctrine' => [
            // Enables or disables Doctrine metadata caching
            // for either performance or convenience during development.
            'dev_mode' => true,

            // Path where Doctrine will cache the processed metadata
            // when 'dev_mode' is false.
            'cache_dir' => APP_ROOT . '/../../var/doctrine',

            // List of paths where Doctrine will search for
            // metadata. Metadata can be either YML/XML files or
            // annotated PHP classes.
            'metadata_dirs' => [APP_ROOT . '/../Model'],

            // The parameters Doctrine needs to connect to your database.
            // Refer to the Doctrine documentation to see the full list
            // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
            // These parameters depend on the driver (for instance the 'pdo_mysql' driver
            // doesn't have a 'path', but needs 'host' and 'port' parameters among others).
            'connection' => [
                'driver' => 'pdo_sqlite',
                'path' => APP_ROOT . '/../../var/assignment.sqlite'
            ]
        ],
        'jwt_authentication' => [
            'secret' => 'eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTY2NTE0Nzk1MCwiaWF0IjoxNjY1MTQ3OTUwfQ.uqRLwOdMhAUZX3QCcrkfzul_r4Op32WBV0dVOa4FKUU',
            'algorithm' => 'HS256',
            'secure' => false, // only for localhost for prod and test env set true
            'error' => static function ($response, $arguments) {
                $data['status'] = 401;
                $data['error'] = 'Unauthorized/'. $arguments['message'];
                return $response
                    ->withHeader('Content-Type', 'application/json;charset=utf-8')
                    ->getBody()->write(json_encode(
                        $data,
                        JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
                    ));
            }
        ],
    ]
];
