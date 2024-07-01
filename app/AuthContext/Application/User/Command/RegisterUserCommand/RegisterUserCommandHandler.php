<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Command\RegisterUserCommand;

use App\AuthContext\Application\User\Command\GeneratePasswordGrantClientAccessTokenCommand\GeneratePasswordGrantClientAccessTokenCommand;
use App\AuthContext\Domain\User\User;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use League\Tactician\CommandBus;

class RegisterUserCommandHandler
{
    private UserRepositoryInterface $userRepository;
    private CommandBus $commandBus;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CommandBus $commandBus
    ) {
        $this->userRepository = $userRepository;
        $this->commandBus = $commandBus;
    }

    public function __invoke(RegisterUserCommand $command): void
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

         $this->commandBus->handle(
             new GeneratePasswordGrantClientAccessTokenCommand(
                 $user->getId()->value()
             )
         );
    }
}