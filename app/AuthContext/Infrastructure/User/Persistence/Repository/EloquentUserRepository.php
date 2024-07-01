<?php

declare(strict_types=1);

namespace App\AuthContext\Infrastructure\User\Persistence\Repository;

use App\AuthContext\Domain\User\Exception\UserNotFoundException;
use App\AuthContext\Domain\User\User;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use App\Models\User as UserEloquent;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByID(UserId $id): User
    {
        $userEloquent = UserEloquent::find($id->value());

        if ($userEloquent === null) {
            throw UserNotFoundException::withId($id);
        }

        return new User(
            new UserId($userEloquent->id),
            $userEloquent->name,
            $userEloquent->email,
            $userEloquent->email_verified_at,
            $userEloquent->password,
            $userEloquent->remember_token
        );
    }

    public function createToken(UserId $id, ?string $name): void
    {
        $name = $name ?? uniqid('token_', true);
        $user = UserEloquent::find($id->value());
        $user->createToken($name);
        $user->save();
    }

    public function save(User $user): void
    {
        $user = new UserEloquent([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);

        $user->save();
    }
}