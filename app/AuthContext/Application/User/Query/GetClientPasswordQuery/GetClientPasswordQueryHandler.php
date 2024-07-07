<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\GetClientPasswordQuery;

use App\AuthContext\Domain\Client\ClientInterface;

class GetClientPasswordQueryHandler
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle(GetClientPasswordQuery $query): GetClientPasswordQueryResult
    {
        return new GetClientPasswordQueryResult(
            $this->client->getClient()
        );
    }
}