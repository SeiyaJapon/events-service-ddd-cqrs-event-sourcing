<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\QueryBus;

use App\EventContext\Application\Query\QueryInterface;
use App\EventContext\Application\Query\QueryResultInterface;
use League\Tactician\CommandBus;

class TacticianQueryBus implements QueryBusInterface
{
    private CommandBus $queryBus;

    public function __construct(CommandBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function ask(QueryInterface $query): QueryResultInterface
    {
        return $this->queryBus->handle($query);
    }
}