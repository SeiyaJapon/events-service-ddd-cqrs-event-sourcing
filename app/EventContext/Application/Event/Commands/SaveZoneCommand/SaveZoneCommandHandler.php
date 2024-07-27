<?php

declare (strict_types=1);

namespace App\EventContext\Application\Event\Commands\SaveZoneCommand;

use App\EventContext\Domain\Event\Repositories\ZoneRepositoryInterface;
use App\EventContext\Domain\Event\Zone;

class SaveZoneCommandHandler
{
    private ZoneRepositoryInterface $zoneRepository;

    public function __construct(ZoneRepositoryInterface $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function handle(SaveZoneCommand $command)
    {
        $this->zoneRepository->save(
            Zone::fromArray($command->getZone())
        );
    }
}