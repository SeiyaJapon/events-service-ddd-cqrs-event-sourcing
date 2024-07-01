<?php

namespace App\AuthContext\Domain\User;

interface UserRepositoryInterface
{
    public function findByID(UserId $id): User;

    public function createToken(UserId $id, ?string $name): void;
    public function save(User $user): void;
}