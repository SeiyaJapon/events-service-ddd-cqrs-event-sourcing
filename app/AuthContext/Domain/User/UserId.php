<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\User;

use App\AuthContext\Domain\ValueObjects\Single\AbstractUuid;

class UserId extends AbstractUuid
{
    public static function random(): self
    {
        return new self(self::randomValue());
    }
}