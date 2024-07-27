<?php
declare(strict_types=1);

namespace App\EventContext\Domain;

abstract class AggregateRoot
{
    private $domainEvents = [];

    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;

        $this->domainEvents = [];

        return $events;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}