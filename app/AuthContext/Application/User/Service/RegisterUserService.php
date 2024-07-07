<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Service;

use App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommand;
use App\AuthContext\Application\User\Query\FindUserByEmailAndPassword\FindUserByEmailQuery;
use App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQuery;
use App\AuthContext\Infrastructure\CommandBus\CommandBusInterface;
use App\AuthContext\Infrastructure\QueryBus\QueryBusInterface;

class RegisterUserService
{
    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;

    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function execute(string $name, string $email, string $password): string
    {
        $this->commandBus->handle(
            new RegisterUserCommand($name, $email, $password)
        );

        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($email)
        );
        $userId = $user->result()['user']['id'];

        $tokenResponse = $this->queryBus->ask(
            new GeneratePasswordGrantClientAccessTokenQuery($userId)
        );

        return $tokenResponse->result()['access_token'];
    }
}