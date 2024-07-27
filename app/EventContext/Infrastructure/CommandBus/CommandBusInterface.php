<?php

declare (strict_types = 1);

namespace App\EventContext\Infrastructure\CommandBus;

use App\EventContext\Application\Command\CommandInterface;

interface CommandBusInterface
{
    public function handle(CommandInterface $command);
}