<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Manager\UrlManager;
use App\Manager\UserManager;

class UserBuilderService
{
    public function __construct(
        private readonly UrlManager $urlManager,
        private readonly UserManager $userManager
    ) {
    }

    /**
     * @param string $login
     * @param string $password
     * @param string $email
     * @param array|null $urls
     * @return User
     */
    public function createUserWithUrl(string $login, string $password, string $email, ?array $urls = []): User
    {
        $user = $this->userManager->create($login, $password, $email);
        foreach ($urls as $url) {
            $this->urlManager->create($user, $url);
        }

        return $user;
    }
}