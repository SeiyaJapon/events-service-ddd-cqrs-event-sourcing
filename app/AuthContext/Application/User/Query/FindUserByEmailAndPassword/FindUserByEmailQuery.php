<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\FindUserByEmailAndPassword;

use App\AuthContext\Application\Query\QueryInterface;

class FindUserByEmailQuery implements QueryInterface
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}