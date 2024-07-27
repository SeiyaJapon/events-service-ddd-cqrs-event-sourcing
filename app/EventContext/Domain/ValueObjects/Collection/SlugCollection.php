<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Collection;

use App\AuthContext\Domain\ValueObjects\Single\Slug;

class SlugCollection extends AbstractCollection
{
    protected function itemClass(): string
    {
        return Slug::class;
    }
}
