<?php

//define constant
const APP_ROOT = __DIR__;


// Should be set to 0 in production
error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

// Settings
$settings = [
    'di_compilation_path' => __DIR__ . '/../var/cache',
    'display_error_details' => false,
    'log_errors' => true,
    'slim' => [
        'displayErrorDetails' => true,
        'logErrors' => true,
        'logErrorDetails' => true,
    ],
    'doctrine' => [
        // Enables or disables Doctrine metadata caching
        // for either performance or convenience during development.
        'dev_mode' => true,

        // Path where Doctrine will cache the processed metadata
        // when 'dev_mode' is false.
        'cache_dir' => APP_ROOT . '/../var/doctrine',

        // List of paths where Doctrine will search for metadata.
        // Metadata can be either YML/XML files or PHP classes annotated
        // with comments or PHP8 attributes.
        'metadata_dirs' => [APP_ROOT . '/../src//Model'],

        // The parameters Doctrine needs to connect to your database.
        // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
        // needs a 'path' parameter and doesn't use most of the ones shown in this example).
        // Refer to the Doctrine documentation to see the full list
        // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
        'connection' => [
            'driver' => 'pdo_sqlite',
            'path' => APP_ROOT . '/../var/assignment.sqlite'
        ]
    ],
    'jwt_authentication' => [
        'secret' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDHAkqU6NyGKUjf+Zlmge/SMELOmTnmo2IeHoPJxzP2iB+lmBX4sMBhi1r3ph6DT0T0bMFKIK7ptWYuTWcsLuoAm/TqieiU8sfSNE2KPNcmoRitgr4qBYgk4mbilYJvrB5jenZYCVCveBzaTFenDkxXNiEdv3KnIaSYtYBd0uCfVwIDAQAB',
        'algorithm' => 'HS256',
        'secure' => false, // only for localhost for prod and test env set true
        'error' => function ($response, $arguments) {
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
];

return $settings;