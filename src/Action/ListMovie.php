<?php

declare(strict_types=1);

namespace Noman\Assignment\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Noman\Assignment\Model\Movie;
use Noman\Assignment\Service\MovieService;
use function json_encode;

class ListMovie
{
    protected MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function __invoke(ServerRequestInterface $request, Response $response, array $args): Response
    {
        $listingId = $request->getAttribute('id');
        if (!empty($listingId)) {
            /** @var Movie $data */
            $data = $this->movieService->getMovie($listingId);
        } else {
            /** @var Movie[] $data */
            $data = $this->movieService->getAllMovies();
        }

        // custom response with header and data
        $response->withHeader('Content-type', 'application/json');
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . PHP_EOL);
        $response->withStatus(200);
        return $response;
    }
}
