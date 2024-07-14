<?php

declare (strict_types = 1);

namespace App\AuthContext\Application\Query;

interface QueryResultInterface
{
    public function result(): array;
}