<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Service;

use App\AuthContext\Domain\Client\ClientInterface;

class CreateGrantPasswordTokenService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function execute(string $clientId, string $clientSecret, string $email, string $password): array
    {
        return $this->client->createGrantPasswordToken(
            $clientId,
            $clientSecret,
            $email,
            $password
        );
    }
}