<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\FindUserByEmailAndPassword;

use App\AuthContext\Domain\User\UserRepositoryInterface;

class FindUserByEmailQueryHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(FindUserByEmailQuery $query): FindUserByEmailQueryResult
    {
        $user = $this->userRepository->findByEmail($query->getEmail());

        return new FindUserByEmailQueryResult($user->toArray());
    }
}