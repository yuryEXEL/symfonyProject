<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Url;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UrlManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create( User $user, string $originalUrl): Url
    {
        $url = new Url();
        $url->setUser($user);
        if(!empty($originalUrl)) {
            $url->setOriginalUrl($originalUrl);
            $minifiedUrl = 'do something';
            $url->setMinifiedUrl($minifiedUrl);
            $url->setCreatedAt();
            $url->setUpdatedAt();
        }
        $user->addUrl($url);
        $this->entityManager->persist($url);
        $this->entityManager->flush();

        return $url;
    }

}
