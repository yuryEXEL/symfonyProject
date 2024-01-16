<?php
declare(strict_types=1);

namespace App\Entity;

interface HasMetaTimestampsInterface
{
    public function getCreatedAt(): ?\DateTime;

    public function getUpdatedAt(): ?\DateTime;

    public function setCreatedAt(): void;

    public function setUpdatedAt(): void;
}
