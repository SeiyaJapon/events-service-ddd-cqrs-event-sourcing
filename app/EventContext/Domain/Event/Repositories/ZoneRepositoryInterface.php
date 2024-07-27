<?php

declare (strict_types=1);

namespace App\EventContext\Domain\Event\Repositories;

use App\EventContext\Domain\Event\Zone;

interface ZoneRepositoryInterface
{
    public function findByEventId(string $eventId): array;

    public function save(Zone $zone): void;
}