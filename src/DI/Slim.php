<?php

declare(strict_types=1);

namespace UMA\Assignment\DI;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ContentLengthMiddleware;
use Tuupola\Middleware\JwtAuthentication;
use UMA\DIC\Container;
use UMA\DIC\ServiceProvider;
use UMA\Assignment\Action\CreateMovie;
use UMA\Assignment\Action\ListMovie;
use UMA\Assignment\Action\LoginAction;
use UMA\Assignment\Service\MovieService;
use UMA\Assignment\Service\UserService;

/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself that wires everything together.
 */
final class Slim implements ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function provide(Container $container): void
    {
        $container->set(ListMovie::class, static function(ContainerInterface $container): RequestHandlerInterface {
            return new ListMovie(new MovieService($container));
        });

        $container->set(CreateMovie::class, static function(ContainerInterface $container): RequestHandlerInterface {
            return new CreateMovie(new MovieService($container));
        });

        $container->set(LoginAction::class, static function(ContainerInterface $container): RequestHandlerInterface {
            return new LoginAction(new UserService($container));
        });
        $container->set(App::class, static function (ContainerInterface $container): App {
            /** @var array $settings */
            $settings = $container->get('settings');

            $app = AppFactory::create(null, $container);

            $app->addErrorMiddleware(
                $settings['slim']['displayErrorDetails'],
                $settings['slim']['logErrors'],
                $settings['slim']['logErrorDetails']
            );

            $app->add(new ContentLengthMiddleware());
//            $app->add(require __DIR__ . '/../App/Dependencies.php');

            $app->post('/login', LoginAction::class);
            $app->get('/movies/{id}', ListMovie::class);
            $app->get('/movies', ListMovie::class);
            $app->post('/movies', CreateMovie::class);
//                ->addMiddleware($container->get(JwtAuthentication::class));

            return $app;
        });
    }
}
