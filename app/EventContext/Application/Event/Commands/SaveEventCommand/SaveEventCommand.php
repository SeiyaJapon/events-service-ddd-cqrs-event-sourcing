<?php

declare (strict_types=1);

namespace App\EventContext\Application\Event\Commands\SaveEventCommand;

use App\EventContext\Application\Command\CommandInterface;

class SaveEventCommand implements CommandInterface
{
    public $eventData;

    public function __construct(array $eventData)
    {
        $this->eventData = $eventData;
    }

    public function getEventData(): array
    {
        return $this->eventData;
    }
}