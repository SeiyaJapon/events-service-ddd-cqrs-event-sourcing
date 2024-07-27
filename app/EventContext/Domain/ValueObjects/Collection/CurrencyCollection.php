<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Collection;

use App\AuthContext\Domain\ValueObjects\Single\Currency;

class CurrencyCollection extends AbstractCollection
{
    protected function itemClass(): string
    {
        return Currency::class;
    }
}
