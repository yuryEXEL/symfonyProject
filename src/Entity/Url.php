<?php
declare(strict_types=1);

namespace App\Entity;

use App\Doctrine\Trait\MetaTimestampsTrait;
use App\Doctrine\UuidGenerator;
use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

#[ORM\Table(name: 'url')]
#[ORM\Entity(repositoryClass: UrlRepository::class)]
#[ORM\Index(columns: ['user_id'], name: 'url__user_id__idx')]
class Url implements HasMetaTimestampsInterface
{
    use MetaTimestampsTrait;

    private const DATE_TIME_FORMAT = 'd-m-Y H:i:s';

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $originalUrl;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $minifiedUrl;

    #[ORM\Column(type: 'integer', length: 11, nullable: true, options: ['default' => 0])]
    private string $countClick;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): void
    {
        $this->originalUrl = $originalUrl;
    }

    public function getMinifiedUrl(): string
    {
        return $this->minifiedUrl;
    }

    public function setMinifiedUrl(string $minifiedUrl): void
    {
        $this->minifiedUrl = $minifiedUrl;
    }


    public function getCountClick(): string
    {
        return $this->countClick;
    }

    public function setCountClick(string $countClick): void
    {
        $this->countClick = $countClick;
    }

    #[ArrayShape([
        'id' => 'int|null',
        'originalUrl' => 'string',
        'minifiedUrl' => 'string',
        'countClick' => 'int|null',
        'createdAt' => 'string',
        'updatedAt' => 'string'
    ])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'originalUrl' => $this->originalUrl,
            'minifiedUrl' => $this->minifiedUrl,
            'countClick' => $this->countClick ?? 0,
            'createdAt' => $this->createdAt?->format(self::DATE_TIME_FORMAT),
            'updatedAt' => $this->updatedAt?->format(self::DATE_TIME_FORMAT)
        ];
    }
}
