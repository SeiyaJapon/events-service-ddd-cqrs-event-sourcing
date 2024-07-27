<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\Event\Listeners;

use App\EventContext\Application\Event\Commands\SaveEventCommand\SaveEventCommand;
use App\EventContext\Domain\Event\Events\EventValidated;
use App\EventContext\Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveEventToDatabase implements ShouldQueue
{
    use InteractsWithQueue;

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(EventValidated $eventValidated)
    {
        $this->commandBus->handle(
            new SaveEventCommand(
                $eventValidated->getData()
            )
        );
    }
}