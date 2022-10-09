<?php

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Add DI container definitions
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Create DI container instance
$container = $containerBuilder->build();

// Inject dependencies
$container = (require __DIR__ . '/../config/dependencies.php')($container);


// Create Slim App instance
$app = $container->get(App::class);

// Register routes
(require __DIR__ . '/../config/routes.php')($app);

// Register middleware
(require __DIR__ . '/../config/middleware.php')($app);

return [
    'app' => $app,
    'container' => $container
];