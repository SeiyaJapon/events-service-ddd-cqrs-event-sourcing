<?php

declare(strict_types=1);

namespace App\AuthContext\Infrastructure\User\Persistence\Repository;

use App\AuthContext\Domain\User\Exception\UserNotFoundException;
use App\AuthContext\Domain\User\User;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use App\Models\User as UserEloquent;
use Illuminate\Support\Facades\Hash;

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

    public function findByEmail(string $email): ?User
    {
        $userEloquent = UserEloquent::where('email', $email)->first();

        if ($userEloquent === null) {
            return null;
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

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        $userEloquent = UserEloquent::where('email', $email)->first();

        if ($userEloquent === null || !Hash::check($password, $userEloquent->password)) {
            return null;
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

    public function createToken(UserId $id, ?string $name): string
    {
        $name = $name ?? uniqid('token_', true);
        $user = UserEloquent::find($id->value());
        $tokenResult = $user->createToken($name);
        return $tokenResult->accessToken;
    }

    public function save(User $user): void
    {
        $newUser = new UserEloquent([
            'id' => $user->getId()->value(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);

        $newUser->save();
    }
}