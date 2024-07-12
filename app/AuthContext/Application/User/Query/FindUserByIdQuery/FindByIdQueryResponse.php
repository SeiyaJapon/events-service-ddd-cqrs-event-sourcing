<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\FindUserByIdQuery;

use App\AuthContext\Application\Query\QueryResultInterface;

class FindByIdQueryResponse implements QueryResultInterface
{
    private array $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function result(): array
    {
        return [
            'id' => $this->user['id'],
            'name' => $this->user['name'],
            'email' => $this->user['email']
        ];
    }
}