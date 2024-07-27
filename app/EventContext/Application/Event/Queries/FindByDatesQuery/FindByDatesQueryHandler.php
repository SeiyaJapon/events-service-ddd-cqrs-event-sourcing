<?php

declare (strict_types=1);

namespace App\EventContext\Application\Event\Queries\FindByDatesQuery;

use App\EventContext\Domain\Event\Repositories\EventRepositoryInterface;

class FindByDatesQueryHandler
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function handle(FindByDatesQuery $query): FindByDatesQueryResult
    {
        return new FindByDatesQueryResult(
            $this->eventRepository->findByDateRange($query->getStartDate(), $query->getEndDate())
        );
    }
}