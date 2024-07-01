<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Collection;

use App\AuthContext\Domain\ValueObjects\Single\Url;

class UrlCollection extends AbstractCollection
{
    protected function itemClass(): string
    {
        return Url::class;
    }
}
