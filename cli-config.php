<?php

use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

/** @var Container $container */
$container = require_once __DIR__ . '/src/App/bootstrap.php';

return ConsoleRunner::run($container->get(EntityManager::class));
