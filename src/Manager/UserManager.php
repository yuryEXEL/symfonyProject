<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\ManageUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

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

    public function saveUserFromDTO(User $user, ManageUserDTO $manageUserDTO): ?int
    {
        $user->setLogin($manageUserDTO->login);
        $user->setPassword($manageUserDTO->password);
        $user->setEmail($manageUserDTO->email);
        $this->saveUser($user);

        return (int)$user->getId();
    }

    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findUser(int $id): ?User
    {
        $repository = $this->getUserRepository();
        $user = $repository->find($id);

        return $user instanceof User ? $user : null;
    }

    public function clearEntityManager(): void
    {
        $this->entityManager->clear();
    }

    /**
     * @return User[]
     */
    public function findUsersByLogin(string $name): array
    {
        return $this->getUserRepository()->findBy(['login' => $name]);
    }

    /**
     * @return User[]
     */
    public function findUsersByEmail(string $email): array
    {
        return $this->getUserRepository()->findBy(['email' => $email]);
    }

    /**
     * @return User[]
     */
    public function findUsersByCriteria(string $email): array
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->eq('email', $email));
        /** @var EntityRepository $repository */
        $repository = $this->getUserRepository();

        return $repository->matching($criteria)->toArray();
    }

    public function updateUserLogin(int $userId, string $login): ?User
    {
        $user = $this->findUser($userId);
        if (!($user instanceof User)) {
            return null;
        }
        $user->setLogin($login);
        $this->entityManager->flush();

        return $user;
    }

    public function findUsersWithQueryBuilder(string $login): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        // SELECT u.* FROM `user` u WHERE u.login LIKE :userLogin
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->andWhere($queryBuilder->expr()->like('u.login',':userLogin'))
            ->setParameter('userLogin', "%$login%");

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return User[]
     */
    public function getUsers(int $page, int $perPage): array
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getUserRepository();

        return $userRepository->getUsers($page, $perPage);
    }

    public function deleteUser(int $userId): bool
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getUserRepository();
        /** @var User $user */
        $user = $userRepository->find($userId);
        if ($user === null) {
            return false;
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return true;
    }

    public function getUserRepository(): UserRepository
    {
        return $this->entityManager->getRepository(User::class);
    }
}
