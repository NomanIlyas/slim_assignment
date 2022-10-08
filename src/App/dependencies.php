<?php

declare(strict_types=1);

use Tuupola\Middleware\JwtAuthentication;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (ContainerBuilder $containerBuilder, array $settings) {
    $containerBuilder->addDefinitions([
        'settings' => $settings,
        JwtAuthentication::class => static function (ContainerInterface $c):  JwtAuthentication {
            return new  JwtAuthentication(
                $c->get('settings')['jwt_authentication']
            );
        },
    ]);
};