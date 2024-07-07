<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\User\Exception;

use App\AuthContext\Domain\User\UserId;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends \DomainException
{
    public static function withId(UserId $id): self
    {
        return new self(sprintf('User with id "%s" not found', $id->value()), Response::HTTP_NOT_FOUND);
    }
}