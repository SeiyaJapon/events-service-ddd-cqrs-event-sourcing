<?php

declare (strict_types=1);

namespace App\AuthContext\Domain\Client;

interface ClientInterface
{
    public function getClient(): array;

    public function createGrantPasswordToken(string $clientId, string $clientSecret, string $email, string $password): array;
}