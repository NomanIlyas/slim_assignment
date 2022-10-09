<?php

use Slim\App;
use Noman\Assignment\Action\CreateMovie;
use Noman\Assignment\Action\ListMovie;
use Noman\Assignment\Action\LoginAction;

return function (App $app) {

    $app->group('/api', function () use ($app) {
        $app->get('/movies/{id}', ListMovie::class);
        $app->get('/movies', ListMovie::class);
        $app->post('/movies', CreateMovie::class);
    })->addMiddleware($app->getContainer()->get('JwtAuthentication'));

    $app->post('/login', LoginAction::class)->setName('api.login');
};
