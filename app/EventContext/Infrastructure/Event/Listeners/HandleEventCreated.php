<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\Event\Listeners;

use App\EventContext\Application\Event\Commands\SaveZoneCommand\SaveZoneCommand;
use App\EventContext\Domain\Event\Events\EventCreated;
use App\EventContext\Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleEventCreated implements ShouldQueue
{
    use InteractsWithQueue;

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(EventCreated $eventValidated)
    {
        $this->commandBus->handle(
            new SaveZoneCommand(
                $eventValidated->getData()
            )
        );
    }
}