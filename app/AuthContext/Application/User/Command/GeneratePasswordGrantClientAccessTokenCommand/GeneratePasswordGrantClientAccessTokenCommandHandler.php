<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Command\GeneratePasswordGrantClientAccessTokenCommand;

use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;

class GeneratePasswordGrantClientAccessTokenCommandHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GeneratePasswordGrantClientAccessTokenCommand $command): void
    {
        $this->userRepository->createToken(new UserId($command->getUserId()), null);

        $this->userRepository->save($user);
    }
}