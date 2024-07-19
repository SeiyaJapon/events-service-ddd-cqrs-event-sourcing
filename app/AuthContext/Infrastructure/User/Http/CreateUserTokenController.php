<?php

declare (strict_types=1);

namespace App\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Application\Client\Query\GetClientPasswordQuery\GetClientPasswordQuery;
use App\AuthContext\Application\User\Service\CreateGrantPasswordTokenService;
use App\AuthContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
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

    public function createToken(Request $request): JsonResponse
    {
        $clientQuery = $this->queryBus->ask(new GetClientPasswordQuery());
        $client = $clientQuery->result()['client'];

        $response = $this->createGrantPasswordTokenService->execute(
            $client['client_id'],
            $client['client_secret'],
            $request->email,
            $request->password
        );

        if ($response['error']) {
            return new JsonResponse($response, Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse($response, Response::HTTP_OK);
    }
}