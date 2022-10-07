<?php

declare(strict_types=1);

namespace UMA\Assignment\Action;

use Exception;
use JsonException;
use Nyholm\Psr7;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Validator;
use UMA\Assignment\Service\MovieService;
use function json_encode;

final class CreateMovie implements RequestHandlerInterface
{
    protected MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws JsonException
     * @throws Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $validator = $this->movieService->container->get('validator')
            ->validate($request, [
                'name' => Validator::stringType()->notBlank(),
                'casts' => Validator::arrayType(),
                'release_date' => Validator::date(),
                'director' => Validator::stringType()->notBlank(),
                'ratings' => Validator::arrayType(),
                ]
        );
        if ($validator->isValid()) {
            // get the movie object and set into response data
            $data = $this->movieService->createMovie($request);
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
