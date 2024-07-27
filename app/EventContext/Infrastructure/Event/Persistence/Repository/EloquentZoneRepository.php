<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\Event\Persistence\Repository;

use App\EventContext\Domain\Event\Repositories\ZoneRepositoryInterface;
use App\EventContext\Domain\Event\Zone;
use App\Models\Zone as ZoneModel;
use Illuminate\Support\Facades\Cache;

class EloquentZoneRepository implements ZoneRepositoryInterface
{
    public function findByEventId(string $eventId): array
    {
        return Cache::remember("zones_event_$eventId", 3600, function() use ($eventId) {
            $zoneModels = ZoneModel::where('event_id', $eventId)->get();
            $zones = [];

            foreach ($zoneModels as $zoneModel) {
                $zones[] = new Zone(
                    $zoneModel->id,
                    $zoneModel->event_id,
                    $zoneModel->name,
                    $zoneModel->capacity,
                    $zoneModel->price,
                    $zoneModel->numbered
                );
            }

            return $zones;
        });
    }

    public function save(Zone $zone): void
    {
        $zoneModel = ZoneModel::find($zone->getId()) ?? new ZoneModel();

        $zoneModel->id = $zone->getId();
        $zoneModel->event_id = $zone->getEventId();
        $zoneModel->name = $zone->getName();
        $zoneModel->capacity = $zone->getCapacity();
        $zoneModel->price = $zone->getPrice();
        $zoneModel->numbered = $zone->isNumbered();

        $zoneModel->save();

        Cache::put("zone_{$zone->getId()}", $zone, 3600);
    }
}