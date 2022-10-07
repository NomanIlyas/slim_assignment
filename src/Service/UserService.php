<?php

namespace UMA\Assignment\Service;

use Doctrine\ORM\EntityManager;
use UMA\DIC\Container;
use UMA\Assignment\Model\User;

class UserService
{
    public Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function validateCredential(string $username, string $password): bool|User
    {
        $user = $this->container->get(EntityManager::class)
            ->getRepository(User::class)
            ->findOneBy([
                'username' => $username
            ]);
        if ($user instanceof User) {
            return (password_verify($password, $user->getHash())) ? $user : false;
        }
        return false;
    }

    public function login($request) {
        $body = $request->getParsedBody();
        $user = $this->validateCredential($body['username'], $body['password']);
        if ($user instanceof User) {
            $user->setToken(bin2hex(openssl_random_pseudo_bytes(8)));
            $user->setTokenExpire(date('Y-m-d H:i:s', strtotime('+4 hour')));

            $this->container->get(EntityManager::class)->persist($user, true);
            $this->container->get(EntityManager::class)->flush();

            return $user;
        }
        return false;
    }
}
