<?php

declare(strict_types=1);

use Slim\App;
use UMA\DIC\Container;
use UMA\Assignment\DI;

/** @var Container $cnt */
$cnt = require __DIR__ . '/bootstrap.php';
$cnt->set('validator', function () { return new Awurth\SlimValidation\Validator; });
$cnt->register(new DI\Doctrine());
$cnt->register(new DI\Slim());
//$cnt->set('dependence', require __DIR__ . '/../App/Dependencies.php');
//$cnt["JwtAuthentication"] =
/** @var App $app */
$app =  $cnt->get(App::class);
//$cnt['JwtAuthentication'] = require __DIR__ . '/../App/middleware.php';

return $app;
