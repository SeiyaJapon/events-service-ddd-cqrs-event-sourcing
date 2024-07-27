<?php

declare (strict_types = 1);

namespace App\EventContext\Application\Query;

interface QueryResultInterface
{
    public function result(): array;
}