<?php
declare(strict_types=1);

namespace App\Entity;

use App\Doctrine\Trait\MetaTimestampsTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements HasMetaTimestampsInterface
{
    use MetaTimestampsTrait;

    private const DATE_TIME_FORMAT = 'd-m-Y H:i:s';

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 32, nullable: false)]
    private string $login;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $email;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
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

    #[ArrayShape([
        'id' => 'int|null',
        'login' => 'string',
        'password' => 'string',
        'email' => 'string',
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
            'createdAt' => $this->createdAt?->format(self::DATE_TIME_FORMAT),
            'updatedAt' => $this->updatedAt?->format(self::DATE_TIME_FORMAT)
        ];
    }
}