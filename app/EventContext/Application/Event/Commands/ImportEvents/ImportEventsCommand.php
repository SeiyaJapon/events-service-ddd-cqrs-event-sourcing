<?php

declare (strict_types=1);

namespace App\EventContext\Application\Event\Commands\ImportEvents;

use App\EventContext\Application\Command\CommandInterface;

class ImportEventsCommand implements CommandInterface
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}