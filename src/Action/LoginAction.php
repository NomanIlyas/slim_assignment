<?php

namespace UMA\Assignment\Action;

use Nyholm\Psr7;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Validator;
use UMA\Assignment\Service\UserService;

final class LoginAction implements RequestHandlerInterface
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $validator = $this->userService->container->get('validator')
            ->validate($request, [
                    'username' => Validator::stringType()->notBlank(),
                    'password' => Validator::stringType()->notBlank()
                ]
            );
        if ($validator->isValid()) {
            // get the movie object and set into response data
            $data = $this->userService->login($request);
        } else {
            $data = $validator->getErrors();
        }
        return new Psr7\Response(
            201,
            ['Content-Type' => 'application/json'],
            Psr7\Stream::create(
                json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . PHP_EOL
            )
        );
    }
}
