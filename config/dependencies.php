<?php

use DI\Container;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Noman\Assignment\Service\MovieService;
use Noman\Assignment\Service\UserService;
use Tuupola\Middleware\JwtAuthentication;

return function (Container $container) {
    // set validator in container
    $container->set('validator', function () {
        return new Awurth\SlimValidation\Validator;
    });

    // inject entity Manager into container
    $container->set('EntityManager', function (Container $c): EntityManager {
        /** @var array $settings */
        $settings = $c->get('settings');

        // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
        // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
        $cache = $settings['doctrine']['dev_mode'] ?
            DoctrineProvider::wrap(new ArrayAdapter()) :
            DoctrineProvider::wrap(new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']));

        $config = Setup::createAttributeMetadataConfiguration(
            $settings['doctrine']['metadata_dirs'],
            $settings['doctrine']['dev_mode'],
            null,
            $cache
        );

        return EntityManager::create($settings['doctrine']['connection'], $config);
    });

    // inject custom services into container
    $container->set('userService', function (Container $c): UserService {
        return new UserService($c);
    });
    $container->set('movieService', function (Container $c): MovieService {
        return new MovieService($c);
    });

    // set JwtAuthentication into container
    $container->set('JwtAuthentication', function (Container $container):  JwtAuthentication {
        /** @var array $settings */
        $container = $container->get('settings');
        return new  JwtAuthentication(
            $container['jwt_authentication'],
        );
    });

    return $container;
};
