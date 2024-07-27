<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\QueryBus;

use App\EventContext\Application\Query\QueryInterface;

interface QueryBusInterface
{
    public function ask(QueryInterface $query);
}