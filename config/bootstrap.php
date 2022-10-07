<?php

declare(strict_types=1);

// bootstrap file for public/index.php and cli-config.php

use UMA\DIC\Container;


require_once __DIR__ . '/../vendor/autoload.php';

return new Container(require __DIR__ . '/../config/settings.php');
