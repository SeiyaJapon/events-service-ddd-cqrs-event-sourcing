<?php

declare(strict_types=1);

namespace App\EventContext\Application\Event\Commands\SaveEventCommand;

use App\EventContext\Domain\Event\Event;
use App\EventContext\Domain\Event\Repositories\EventRepositoryInterface;

class SaveEventCommandHandler
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(SaveEventCommand $command)
    {
        $this->eventRepository->save(
            Event::fromArray($command->getEventData())
        );
    }
}