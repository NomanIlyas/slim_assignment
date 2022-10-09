<?php

use Slim\App;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Handle exceptions
    $app->addErrorMiddleware(
        $app->getContainer()->get('settings')['slim']['displayErrorDetails'] ?? true,
            $app->getContainer()->get('settings')['slim']['logErrors'] ?? true,
            $app->getContainer()->get('settings')['slim']['logErrorDetails'] ?? true
    );
};
