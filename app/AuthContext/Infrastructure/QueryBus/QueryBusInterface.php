<?php

declare (strict_types=1);

namespace App\AuthContext\Infrastructure\QueryBus;

use App\AuthContext\Application\Query\QueryInterface;

interface QueryBusInterface
{
    public function ask(QueryInterface $query);
}