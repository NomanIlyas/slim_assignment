<?php

declare(strict_types=1);

namespace Noman\Assignment\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;
use Noman\Assignment\Service\MovieService;

use function json_encode;

class CreateMovie
{
    protected MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }


    public function __invoke(ServerRequestInterface $request, Response $response, array $args): Response
    {
        $statusCode = 201;
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
            $statusCode = 400;
        }

        // custom response with header and data
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);
        $response->withHeader('Content-type', 'application/json');
        $response->withStatus($statusCode);
        return $response;
    }
}
