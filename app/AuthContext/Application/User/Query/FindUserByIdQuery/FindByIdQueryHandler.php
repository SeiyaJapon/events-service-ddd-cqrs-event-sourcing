<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\FindUserByIdQuery;

use App\AuthContext\Domain\User\UserRepositoryInterface;

class FindByIdQueryHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(FindByIdQuery $query): FindByIdQueryResponse
    {
        $user = $this->userRepository->findById($query->getId());

        return new FindByIdQueryResponse($user->toArray());
    }
}