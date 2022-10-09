<?php

namespace Noman\Assignment\Service;

use DI\Container;
use Noman\Assignment\Model\User;

class UserService
{
    public Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function validateCredential(string $username, string $password): bool|User
    {
        $user = $this->container->get('EntityManager')
            ->getRepository(User::class)
            ->findOneBy([
                'username' => $username
            ]);
        if ($user instanceof User) {
            return (password_verify($password, $user->getHash())) ? $user : false;
        }
        return false;
    }

    public function login($request): bool|User
    {

        $body = $request->getParsedBody();
        $user = $this->validateCredential($body['username'], $body['password']);
        if ($user instanceof User) {
            $user->setToken(bin2hex(openssl_random_pseudo_bytes(8)));
            $this->container->get('EntityManager')->persist($user);
            $this->container->get('EntityManager')->flush();

            return $user;
        }
        return false;
    }
}
