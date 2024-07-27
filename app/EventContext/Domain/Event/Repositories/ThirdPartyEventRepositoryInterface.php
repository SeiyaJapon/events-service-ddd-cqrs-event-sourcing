<?php

declare (strict_types=1);

namespace App\EventContext\Domain\Event\Repositories;

interface ThirdPartyEventRepositoryInterface
{
    public function import(string $url): void;
}