<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\User\Exception;

use App\AuthContext\Domain\User\UserId;
use Symfony\Component\HttpFoundation\Response;

class UserTokenNotFoundException extends \DomainException
{
    public static function withId(UserId $id): self
    {
        return new self(sprintf('User token for user with id "%s" not found', $id->value()), Response::HTTP_NOT_FOUND);
    }
}