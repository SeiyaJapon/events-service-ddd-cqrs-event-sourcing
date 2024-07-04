<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery;

use App\AuthContext\Application\Query\QueryResultInterface;

class GeneratePasswordGrantClientAccessTokenQueryResponse implements QueryResultInterface
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function result(): array
    {
        return [
            'access_token' => $this->token
        ];
    }
}