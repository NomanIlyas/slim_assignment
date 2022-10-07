<?php

declare(strict_types=1);

namespace UMA\Assignment\Action;

use Nyholm\Psr7;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UMA\Assignment\Model\Movie;
use UMA\Assignment\Service\MovieService;
use function json_encode;

final class ListMovie implements RequestHandlerInterface
{
    protected MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @throws \JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $route = $request->getAttribute('route');
        $listingId = (!empty($route)) ? $route->getArgument('id') : null;
        if (!empty($listingId) && is_int($listingId)) {
            /** @var Movie $data */
            $data = $this->movieService->getMovie($listingId);
        } else {
            /** @var Movie[] $data */
            $data = $this->movieService->getAllMovies();
        }

        return new Psr7\Response(
            200,
            ['Content-Type' => 'application/json'],
            Psr7\Stream::create(
                json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . PHP_EOL)
            );
    }
}
