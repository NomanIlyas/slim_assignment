<?php

declare(strict_types=1);

namespace Noman\Assignment\Model;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;
use ReturnTypeWillChange;
use function password_hash;

// The User class demonstrates how to annotate a simple PHP class to act as a Doctrine entity.

#[Entity, Table(name: 'users')]
final class User implements JsonSerializable
{
    /*ToDo Prefer to used uuid (Type) instead of integer id */
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', unique: true, nullable: false)]
    private string $email;

    #[Column(type: 'string', nullable: true)]
    private string $username;

    #[Column(type: 'string', nullable: true)]
    private string $token;

    #[Column(name: 'bcrypt_hash', type: 'string', length: 120)]
    private string $hash;

    #[Column(name: 'registered_at', type: 'datetimetz_immutable' )]
    private DateTimeImmutable $registeredAt;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->hash = password_hash($password, PASSWORD_BCRYPT);
        $this->registeredAt = new DateTimeImmutable('now');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }


    /**
     * {@inheritdoc}
     */
    #[ReturnTypeWillChange] public function jsonSerialize()
    {
        return [
            'email' => $this->getEmail(),
            'username' => $this->getUsername(),
            'token' => $this->getToken(),
        ];
    }
}
