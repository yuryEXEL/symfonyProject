<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create(string $login, string $password, string $email): User
    {
        $user = new User();
        $user->setLogin($login);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setCreatedAt();
        $user->setUpdatedAt();
        $this->saveUser($user);

        return $user;
    }

    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function clearEntityManager(): void
    {
        $this->entityManager->clear();
    }
}
