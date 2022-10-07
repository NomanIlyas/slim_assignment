<?php

namespace UMA\Assignment\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;
use UMA\DIC\Container;
use UMA\Assignment\Model\Movie;

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

        $this->container->get(EntityManager::class)->persist($movie, true);
        $this->container->get(EntityManager::class)->flush();

        return $movie;
    }

    public function getAllMovies()
    {
        return $this->container->get(EntityManager::class)
            ->getRepository(Movie::class)
            ->findAll();
    }

    public function getMovie(int $listingId)
    {
        return $this->container->get(EntityManager::class)
            ->getRepository(Movie::class)
            ->find($listingId);
    }
}
