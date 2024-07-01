<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Command\GeneratePasswordGrantClientAccessTokenCommand;

class GeneratePasswordGrantClientAccessTokenCommand
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}