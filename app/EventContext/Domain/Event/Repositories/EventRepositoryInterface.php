<?php

declare (strict_types=1);

namespace App\EventContext\Domain\Event\Repositories;

use App\EventContext\Domain\Event\Event;

interface EventRepositoryInterface
{
    public function findById(string $id): ?Event;

    public function findByDateRange(string $startsAt, string $endsAt, int $perPage = 1000, int $page = 1): array;

    public function save(Event $event): void;
}