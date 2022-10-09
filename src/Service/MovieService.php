<?php

namespace Noman\Assignment\Service;

use DateTimeImmutable;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;
use Noman\Assignment\Model\Movie;

class MovieService
{
    public Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function createMovie(ServerRequestInterface $request)
    {
        $body = $request->getParsedBody();
        $movie = new Movie();
        $movie->setName($body['name']);
        $movie->setDirector($body['director']);
        $movie->setCast($body['casts']);
        $movie->setReleasedDate(new DateTimeImmutable($body['release_date']));
        $movie->setRating($body['ratings']);

        $this->container->get('EntityManager')->persist($movie, true);
        $this->container->get('EntityManager')->flush();

        return $movie;
    }

    public function getAllMovies()
    {
        return $this->container->get('EntityManager')
            ->getRepository(Movie::class)
            ->findAll();
    }

    public function getMovie(string $listingId)
    {
        return $this->container->get('EntityManager')
            ->getRepository(Movie::class)
            ->find($listingId);
    }
}
