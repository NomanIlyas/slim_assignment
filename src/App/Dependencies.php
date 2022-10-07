<?php

declare(strict_types=1);

use Tuupola\Middleware\JwtAuthentication;
use UMA\DIC\Container;

return [
    JwtAuthentication::class => static function (Container $container):  JwtAuthentication {
        return new  JwtAuthentication(
            $container->get('jwt_authentication'),
        );
    },
];
