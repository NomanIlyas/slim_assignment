<?php

use DI\ContainerBuilder;

require 'vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

//$settings = include '/../src/settings.php';
$settings = require __DIR__ . '/settings.php';
$settings($containerBuilder);

// Build PHP-DI Container instance
return $containerBuilder->build();