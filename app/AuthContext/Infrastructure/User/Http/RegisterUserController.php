<?php

declare(strict_types=1);

namespace App\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommand;
use App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQuery;
use App\AuthContext\Infrastructure\CommandBus\CommandBusInterface;
use App\AuthContext\Infrastructure\QueryBus\QueryBusInterface;
use App\AuthContext\Infrastructure\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterUserController
{

    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;

    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function register(Request $request): JsonResponse
    {
        $this->commandBus->handle(
            new RegisterUserCommand(
                $request->name,
                $request->email,
                $request->password
            )
        );

        $user = $this->queryBus->ask(
            new FindUserByEmailAndPasswordQuery($request->email, $request->password)
        );

        return new JsonResponse($user->result(), 201);
    }
}