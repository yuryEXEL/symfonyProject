<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Url;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function findByMinifiedUrl(string $url): ?Url
    {
        return $this->findOneBy(['minifiedUrl' => $url]);
    }
}
