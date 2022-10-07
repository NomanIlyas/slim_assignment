<?php

use Tuupola\Middleware\JwtAuthentication;

public function JwtAuthentication(container)
{
    return JwtAuthentication([
        "path" => "/",
        "ignore" => ["/api/v1/login"],
        "secret" => 'eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTY2NTE0Nzk1MCwiaWF0IjoxNjY1MTQ3OTUwfQ.uqRLwOdMhAUZX3QCcrkfzul_r4Op32WBV0dVOa4FKUU',
        "logger" => $container["logger"],
        "attribute" => false,
        "relaxed" => ["127.0.0.1", "localhost"],
        "error" => function ($response, $arguments) {
            return new UnauthorizedResponse($arguments["message"], 401);
        },
        "before" => function ($request, $arguments) use ($container) {
            $container["token"]->populate($arguments["decoded"]);
        }
    ]);

}

$app->add("JwtAuthentication", JwtAuthentication($app->getcontainer());

