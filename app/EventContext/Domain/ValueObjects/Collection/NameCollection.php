<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Collection;

use App\AuthContext\Domain\ValueObjects\Single\Name;

class NameCollection extends AbstractCollection
{
    protected function itemClass(): string
    {
        return Name::class;
    }
}
