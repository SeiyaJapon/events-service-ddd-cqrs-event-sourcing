<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery;

use App\AuthContext\Domain\User\UserRepositoryInterface;

class FindUserByEmailAndPasswordQueryHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(FindUserByEmailAndPasswordQuery $query): FindUserByEmailAndPasswordQueryResult
    {
        $user = $this->userRepository->findByEmailAndPassword($query->getEmail(), $query->getPassword());

        return new FindUserByEmailAndPasswordQueryResult($user->toArray());
    }
}