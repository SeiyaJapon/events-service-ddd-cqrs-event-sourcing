<?php

declare (strict_types = 1);

namespace App\AuthContext\Infrastructure\CommandBus;

use App\AuthContext\Application\Command\CommandInterface;

interface CommandBusInterface
{
    public function handle(CommandInterface $command);
}