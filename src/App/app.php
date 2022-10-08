<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestHandler;

require __DIR__.'/../../vendor/autoload.php';

$settings = (require __DIR__ . '/settings.php');

// Set up dependencies
$containerBuilder = new ContainerBuilder();
//if($settings['di_compilation_path']) {
//    $containerBuilder->enableCompilation($settings['di_compilation_path']);
//}

(require __DIR__ . '/dependencies.php')($containerBuilder, $settings);

// Create app
AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

(require __DIR__ . '/../../cli-config.php')($app);

// Assign matched route arguments to Request attributes for PSR-15 handlers
$app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler(true));

// Register middleware
(require __DIR__ . '/middleware.php')($app);
return $app;
