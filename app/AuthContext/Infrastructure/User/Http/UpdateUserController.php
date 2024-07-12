<?php

declare (strict_types=1);

namespace App\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Application\User\Command\UpdateUserCommand\UpdateUserCommand;
use App\AuthContext\Application\User\Query\FindUserByIdQuery\FindByIdQuery;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Infrastructure\CommandBus\CommandBusInterface;
use App\AuthContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateUserController
{
    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;

    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function update(Request $request)
    {
        $this->commandBus->handle(
            new UpdateUserCommand(
                $request->input('id'),
                $request->input('name'),
                $request->input('email'),
                $request->input('password')
            )
        );

        $user = $this->queryBus->ask(
            new FindByIdQuery(new UserId($request->input('id')))
        );

        return response()->json($user->result(), Response::HTTP_OK);
    }
}