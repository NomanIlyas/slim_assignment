<?php

// cli-config.php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = (require_once __DIR__ .'/config/bootstrap.php')['container'];

return ConsoleRunner::createHelperSet($container->get('EntityManager'));