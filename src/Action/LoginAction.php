<?php

namespace Noman\Assignment\Action;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

class LoginAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, array $args): Response
    {
        $statusCode = 201;
        $validator = $this->container->get('validator')
            ->validate($request, [
                    'username' => Validator::stringType()->notBlank(),
                    'password' => Validator::stringType()->notBlank()
                ]
            );

        if ($validator->isValid()) {
            $data = $this->container->get('userService')->login($request);
        } else {
            $data = $validator->getErrors();
            $statusCode = 400;
        }

        // custom response with header and data
        $response->withHeader('Content-type', 'application/json');
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . PHP_EOL);
        $response->withStatus($statusCode);
        return $response;
    }
}
