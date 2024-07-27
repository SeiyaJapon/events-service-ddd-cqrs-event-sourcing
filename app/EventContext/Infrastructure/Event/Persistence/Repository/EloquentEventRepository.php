<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\Event\Persistence\Repository;

use App\EventContext\Domain\Event\Event;
use App\EventContext\Domain\Event\Repositories\EventRepositoryInterface;
use App\EventContext\Domain\Event\Repositories\ZoneRepositoryInterface;
use App\EventContext\Infrastructure\Event\Services\EventDispatcherService;
use App\Models\Event as EventModel;
use Illuminate\Support\Facades\Cache;

class EloquentEventRepository implements EventRepositoryInterface
{
    private EventDispatcherService $eventDispatcherService;
    private ZoneRepositoryInterface $zoneRepository;

    public function __construct(EventDispatcherService $eventDispatcherService, ZoneRepositoryInterface $zoneRepository)
    {
        $this->eventDispatcherService = $eventDispatcherService;
        $this->zoneRepository = $zoneRepository;
    }

    public function findById(string $id): ?Event
    {
        return Cache::remember("event_$id", 3600, function() use ($id) {
            if ($eventModel = EventModel::find($id)) {
                return new Event(
                    $eventModel->id,
                    $eventModel->title,
                    $eventModel->start_date,
                    $eventModel->start_time,
                    $eventModel->end_date,
                    $eventModel->end_time
                );
            }

            return null;
        });
    }

    public function findByDateRange(string $startsAt, string $endsAt, int $perPage = 1000, int $page = 1): array
    {
        return Cache::remember(
            "events_{$startsAt}_{$endsAt}_{$perPage}_{$page}",
            3600,
            function () use ($startsAt, $endsAt, $perPage, $page) {
                $eventModels = EventModel::whereBetween('start_date', [$startsAt, $endsAt])
                    ->paginate($perPage, ['*'], 'page', $page);
                $events = [];

                foreach ($eventModels as $eventModel) {
                    $item = new Event(
                        $eventModel->id,
                        $eventModel->title,
                        $eventModel->start_date->format('Y-m-d'),
                        $eventModel->start_time,
                        $eventModel->end_date->format('Y-m-d'),
                        $eventModel->end_time
                    );

                    $zones = $this->zoneRepository->findByEventId($eventModel->id);

                    foreach ($zones as $zone) {
                        $item->addZone($zone);
                    }

                    $events[] = $item->toArray();
                }

                return [
                    'data' => $events,
                    'current_page' => $eventModels->currentPage(),
                    'last_page' => $eventModels->lastPage(),
                    'per_page' => $eventModels->perPage(),
                    'total' => $eventModels->total(),
                ];
            }
        );
    }

    public function save(Event $event): void
    {
        $eventModel = EventModel::find($event->getId());
        $isNew = !$eventModel;

        if ($isNew) {
            $eventModel = new EventModel();
        }

        $eventModel->id = $event->getId();
        $eventModel->title = $event->getTitle();
        $eventModel->start_date = $event->getStartDate();
        $eventModel->start_time = $event->getStartTime();
        $eventModel->end_date = $event->getEndDate();
        $eventModel->end_time = $event->getEndTime();
        $eventModel->save();

        Cache::put("event_{$event->getId()}", $event, 3600);

        foreach ($event->getZones() as $zone) {
            if ($isNew) {
                $this->eventDispatcherService->dispatchEventCreated($zone->toArray());
            } else {
                $this->eventDispatcherService->dispatchEventUpdated($zone->toArray());
            }
        }
    }
}