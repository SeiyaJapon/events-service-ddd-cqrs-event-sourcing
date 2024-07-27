<?php

declare(strict_types=1);

namespace App\EventContext\Application\Event\Queries\FindByDatesQuery;

use App\EventContext\Application\Query\QueryResultInterface;

class FindByDatesQueryResult implements QueryResultInterface
{
    private array $events;

    public function __construct(array $events)
    {
        $this->events = $events;
    }

    public function result(): array
    {
        return [
            'events' => $this->events
        ];
    }
}