<?php

declare(strict_types=1);

namespace App\EventContext\Infrastructure\Event\Services;

use App\EventContext\Domain\Event\Events\EventCreated;
use App\EventContext\Domain\Event\Events\EventUpdated;
use App\EventContext\Domain\Event\Events\EventValidated;
use Illuminate\Contracts\Events\Dispatcher;

class EventDispatcherService
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatchEventValidated(array $eventData): void
    {
        $eventValidated = new EventValidated(
            uniqid(),
            $eventData['@attributes']['base_event_id'],
            [],
            $eventData['event'],
            new \DateTimeImmutable()
        );

        $this->dispatcher->dispatch($eventValidated);
    }

    public function dispatchEventCreated(array $eventData): void
    {
        $eventCreated = new EventCreated(
            uniqid(),
            $eventData['id'],
            [],
            $eventData,
            new \DateTimeImmutable()
        );

        $this->dispatcher->dispatch($eventCreated);
    }

    public function dispatchEventUpdated(array $eventData): void
    {
        $eventUpdated = new EventUpdated(
            uniqid(),
            $eventData['id'],
            [],
            $eventData,
            new \DateTimeImmutable()
        );

        $this->dispatcher->dispatch($eventUpdated);
    }
}