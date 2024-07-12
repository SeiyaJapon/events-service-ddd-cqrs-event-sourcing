<?php

declare (strict_types=1);

namespace App\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Application\User\Query\GetClientPasswordQuery\GetClientPasswordQuery;
use App\AuthContext\Application\User\Service\CreateGrantPasswordTokenService;
use App\AuthContext\Domain\Client\ClientInterface;
use App\AuthContext\Infrastructure\CommandBus\CommandBusInterface;
use App\AuthContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateUserTokenController
{
    private QueryBusInterface $queryBus;
    private CreateGrantPasswordTokenService $createGrantPasswordTokenService;

    public function __construct(
        QueryBusInterface $queryBus,
        CreateGrantPasswordTokenService $createGrantPasswordTokenService
    ) {
        $this->queryBus = $queryBus;
        $this->createGrantPasswordTokenService = $createGrantPasswordTokenService;
    }

    public function createToken(Request $request)
    {
        $clientQuery = $this->queryBus->ask(new GetClientPasswordQuery());
        $client = $clientQuery->result()['client'];

        $response = $this->createGrantPasswordTokenService->execute(
            $client['client_id'],
            $client['client_secret'],
            $request->email,
            $request->password
        );

        return response()->json($response, Response::HTTP_OK);
    }
}