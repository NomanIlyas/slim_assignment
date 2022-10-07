<?php

declare(strict_types=1);

namespace UMA\Assignment\Model;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;
use ReturnTypeWillChange;
use UMA\Assignment\Model\Generator\UuidGenerator;

// The Movie class demonstrates how to annotate a simple PHP class to act as a Doctrine entity.

#[Entity, Table(name: 'movies')]
class Movie implements JsonSerializable
{
    // always prefer UUID rather than integer id
   #[Id, Column(type: 'string', length: 191, unique: true), GeneratedValue(strategy: 'CUSTOM'), CustomIdGenerator(class: UuidGenerator::class)]
    private $id;

    #[Column(name: 'name',type: 'string', length: 120)]
    private string $name;

    #[Column(name: 'director', type: 'string', length: 120)]
    private string $director;

    #[Column(name:'cast', type: 'json_array')]
    private array $cast;

    #[Column(name: 'released_date', type: 'datetimetz_immutable')]
    private DateTimeImmutable $releasedDate;

    #[Column(name:'rating', type: 'json_array')]
    private array $rating;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDirector(): string
    {
        return $this->director;
    }

    /**
     * @param string $director
     */
    public function setDirector(string $director): void
    {
        $this->director = $director;
    }

    /**
     * @return array
     */
    public function getCast(): array
    {
        return $this->cast;
    }

    /**
     * @param array $cast
     */
    public function setCast(array $cast): void
    {
        $this->cast = $cast;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getReleasedDate(): DateTimeImmutable
    {
        return $this->releasedDate;
    }

    /**
     * @param DateTimeImmutable $releasedDate
     */
    public function setReleasedDate(DateTimeImmutable $releasedDate): void
    {
        $this->releasedDate = $releasedDate;
    }

    /**
     * @return array
     */
    public function getRating(): array
    {
        return $this->rating;
    }

    /**
     * @param array $rating
     */
    public function setRating(array $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * {@inheritdoc}
     */
    #[ReturnTypeWillChange] public function jsonSerialize()
    {
        // can also use DTO but same our purpose fulfill with this function
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'cast' => $this->getCast(),
            'released_date' => $this->getReleasedDate()
                ->format('d-m-Y'), // date format as per the requirements
            'director' => $this->getDirector(),
            'rating' => $this->getRating(),
        ];
    }
}
