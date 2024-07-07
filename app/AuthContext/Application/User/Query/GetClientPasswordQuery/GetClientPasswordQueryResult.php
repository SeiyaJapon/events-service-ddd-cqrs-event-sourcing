<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\GetClientPasswordQuery;

use App\AuthContext\Application\Query\QueryResultInterface;

class GetClientPasswordQueryResult implements QueryResultInterface
{
    private array $client;

    public function __construct(array $client)
    {
        $this->client = $client;
    }

    public function result(): array
    {
        return [
            'client' => $this->client
        ];
    }
}