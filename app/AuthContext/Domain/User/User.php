<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\User;

class User
{
    private $id;
    private $name;
    private $email;
    private $emailVerifiedAt;
    private $password;
    private $rememberToken;

    public function __construct(
        UserId $id,
        string $name,
        string $email,
        ?string $emailVerifiedAt,
        string $password,
        ?string $rememberToken
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setEmailVerifiedAt(?string $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRememberToken(?string $rememberToken): void
    {
        $this->rememberToken = $rememberToken;
    }

    public function toArray()
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->emailVerifiedAt,
            'password' => $this->password,
            'remember_token' => $this->rememberToken
        ];
    }
}