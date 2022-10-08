<?php

use UMA\Assignment\Command\ExampleCommand;

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ExampleCommand());
$application->run();