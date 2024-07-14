<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Command\RegisterUserCommand;

use App\AuthContext\Domain\User\User;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;

class RegisterUserCommandHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterUserCommand $command): void
    {
         $user = new User(
             UserId::random(),
             $command->getName(),
             $command->getEmail(),
             null,
             $command->getPassword(),
             null
         );

         $this->userRepository->save($user);
    }
}