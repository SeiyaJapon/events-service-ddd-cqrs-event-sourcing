<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Command\UpdateUserCommand;

use App\AuthContext\Domain\User\UserRepositoryInterface;

class UpdateUserCommandHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(UpdateUserCommand $command): void
    {
        $this->userRepository->update(
            $command->getId(),
            $command->getName(),
            $command->getEmail(),
            $command->getPassword()
        );
    }
}