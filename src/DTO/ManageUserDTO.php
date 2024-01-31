<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Url;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

class ManageUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 32)]
        public string $login = '',

        #[Assert\NotBlank]
        #[Assert\Length(min: 5, max: 32)]
        public string $password = '',

        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email = '',

        #[Assert\Type('array')]
        public array $urls = [],
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(...[
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'urls' => array_map(
                static function (Url $url) {
                    return [
                        'id' => $url->getId(),
                        'originalUrl' => $url->getOriginalUrl(),
                        'minifiedUrl' => $url->getMinifiedUrl(),
                    ];
                },
                $user->getUrls()
            ),
        ]);
    }
}
