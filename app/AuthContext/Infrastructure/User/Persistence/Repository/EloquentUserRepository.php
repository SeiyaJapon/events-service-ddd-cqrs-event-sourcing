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
        $userEloquent = $this->getById($id->value());

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
        $userEloquent = $this->getUserEloquentByEmail($email);

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
        $userEloquent = $this->getUserEloquentByEmail($email);

        if ($this->assertUsereloquentIsNotNullAndPasswordIsCorrect($userEloquent, $password)) {
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
        $user = $this->getById($id->value());
        $tokenResult = $user->createToken($name);

        return $tokenResult->accessToken;
    }

    public function update(string $id, string $name, string $email, string $password): void
    {
        $userEloquent = $this->getById($id);

        $userEloquent->name = $name;
        $userEloquent->email = $email;

        if ($password !== null) {
            $userEloquent->password = Hash::make($password);
        }

        $userEloquent->save();
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

    private function getUserEloquentByEmail(string $email): ?UserEloquent
    {
        return UserEloquent::where('email', $email)->first();
    }

    private function assertUsereloquentIsNotNullAndPasswordIsCorrect(?UserEloquent $userEloquent, string $password)
    {
        return $userEloquent === null || !Hash::check($password, $userEloquent->password);
    }

    private function getById(string $id)
    {
        return UserEloquent::find($id);
    }
}