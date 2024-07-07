<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery;

use App\AuthContext\Application\Query\QueryResultInterface;

class FindUserByEmailAndPasswordQueryResult implements QueryResultInterface
{
    private array $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function result(): array
    {
        return [
            'user' => $this->user
        ];
    }
}