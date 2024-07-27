<?php

declare(strict_types=1);

namespace App\EventContext\Application\Event\Queries\FindByDatesQuery;

use App\EventContext\Application\Query\QueryInterface;

class FindByDatesQuery implements QueryInterface
{
    private string $startDate;
    private string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }
}