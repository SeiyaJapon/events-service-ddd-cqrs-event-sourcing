<?php

declare (strict_types=1);

namespace App\AuthContext\Infrastructure\QueryBus;

use App\AuthContext\Application\Query\QueryInterface;
use App\AuthContext\Application\Query\QueryResultInterface;
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