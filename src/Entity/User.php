<?php
declare(strict_types=1);

namespace App\Entity;

use App\Doctrine\UuidGenerator;
use App\Doctrine\Trait\MetaTimestampsTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'users__email__uidx', columns: ['email'])]
class User implements HasMetaTimestampsInterface
{
    use MetaTimestampsTrait;

    private const DATE_TIME_FORMAT = 'd-m-Y H:i:s';

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id = null;

    #[ORM\Column(type: 'string', length: 32, nullable: false)]
    private string $login;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $password;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $email;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Url::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'SET NULL')]
    private Collection $urls;

    public function __construct()
    {
        $this->urls = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function addUrl(Url $url): void
    {
        if (!$this->urls->contains($url)) {
            $this->urls->add($url);
        }
    }

    #[ArrayShape([
        'id' => 'int|null',
        'login' => 'string',
        'password' => 'string',
        'email' => 'string',
        'url' => [
            'id' => 'int|null',
            'originalUrl' => 'string',
            'minifiedUrl' => 'string',
            'countClick' => 'int|null',
            'createdAt' => 'string',
            'updatedAt' => 'string'
        ],
        'createdAt' => 'string',
        'updatedAt' => 'string'
    ])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'password' => $this->password,
            'email' => $this->email,
            'url' => array_map(static fn(Url $url) => $url->toArray(), $this->urls->toArray()),
            'createdAt' => $this->createdAt?->format(self::DATE_TIME_FORMAT),
            'updatedAt' => $this->updatedAt?->format(self::DATE_TIME_FORMAT)
        ];
    }
}