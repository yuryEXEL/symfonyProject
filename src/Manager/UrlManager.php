<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Url;
use Doctrine\ORM\EntityManagerInterface;

class UrlManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create(string $originalUrl): Url
    {
        $url = new Url();
        $url->setOriginalUrl($originalUrl);
        $minifiedUrl = 'do something';
        $url->setMinifiedUrl($minifiedUrl);
        $url->setCreatedAt();
        $url->setUpdatedAt();
        $this->entityManager->persist($url);
        $this->entityManager->flush();

        return $url;
    }
}
