<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Command\RegisterUserCommand;

use App\AuthContext\Application\Command\CommandInterface;

class RegisterUserCommand implements CommandInterface
{
    private string $name;
    private string $email;
    private string $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}