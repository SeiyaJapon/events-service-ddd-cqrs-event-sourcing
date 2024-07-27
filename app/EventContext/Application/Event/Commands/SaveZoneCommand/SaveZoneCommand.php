<?php

declare (strict_types=1);

namespace App\EventContext\Application\Event\Commands\SaveZoneCommand;

use App\EventContext\Application\Command\CommandInterface;

class SaveZoneCommand implements CommandInterface
{
    private array $zone;

    public function __construct(array $zone)
    {
        $this->zone = $zone;
    }

    public function getZone(): array
    {
        return $this->zone;
    }
}