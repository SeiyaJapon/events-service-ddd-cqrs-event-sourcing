<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Collection;

use App\AuthContext\Domain\ValueObjects\Single\Description;

class DescriptionCollection extends AbstractCollection
{
    protected function itemClass(): string
    {
        return Description::class;
    }
}
