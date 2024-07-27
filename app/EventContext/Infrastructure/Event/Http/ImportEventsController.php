<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\Event\Http;

use app\EventContext\Application\Event\Commands\ImportEvents\ImportEventsCommand;
use App\EventContext\Infrastructure\CommandBus\CommandBusInterface;
use App\EventContext\Infrastructure\Event\Resources\ThirdPartyRoutes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportEventsController
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function importEvents(Request $request): JsonResponse
    {
        $this->commandBus->handle(
            new ImportEventsCommand(
                $request->url ?? ThirdPartyRoutes::EVENT_PROVIDER_URL
            )
        );

        return new JsonResponse(['message' => 'Events imported successfully']);
    }
}