<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Collection;

use App\AuthContext\Domain\ValueObjects\Single\Coordinates;

class CoordinatesCollection extends AbstractCollection
{
    protected function itemClass(): string
    {
        return Coordinates::class;
    }
}
