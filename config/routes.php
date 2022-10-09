<?php

use Slim\App;
use Noman\Assignment\Action\CreateMovie;
use Noman\Assignment\Action\ListMovie;
use Noman\Assignment\Action\LoginAction;

return function (App $app) {
    $app->post('/login', LoginAction::class)->setName('api.login');
    $app->get('/movies/{id}', ListMovie::class)->getName('get_movie');
    $app->get('/movies', ListMovie::class)->getName('get_movies');
    $app->post('/movies', CreateMovie::class)->getName('post_movie');
};
