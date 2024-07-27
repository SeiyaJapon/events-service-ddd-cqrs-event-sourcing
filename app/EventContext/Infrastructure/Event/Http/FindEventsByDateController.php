<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\Event\Http;

use App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQuery;
use App\EventContext\Infrastructure\QueryBus\QueryBusInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindEventsByDateController
{
    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function findEventsByDate(Request $request): JsonResponse
    {
        try {
            $result = $this->queryBus->ask(
                new FindByDatesQuery(
                    $request->get('startDate'),
                    $request->get('endDate')
                )
            );

            return new JsonResponse($result->result(), Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
}