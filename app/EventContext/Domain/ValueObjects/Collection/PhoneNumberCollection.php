<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Collection;

use App\AuthContext\Domain\ValueObjects\Single\PhoneNumber;

class PhoneNumberCollection extends AbstractCollection
{
    protected function itemClass(): string
    {
        return PhoneNumber::class;
    }
}
