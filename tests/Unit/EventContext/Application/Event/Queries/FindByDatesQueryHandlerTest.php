<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Application\Event\Queries\FindByDatesQuery;

use App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQuery;
use App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQueryHandler;
use App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQueryResult;
use App\EventContext\Domain\Event\Repositories\EventRepositoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class FindByDatesQueryHandlerTest extends TestCase
{
    private MockObject $eventRepository;
    private FindByDatesQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventRepository = $this->createMock(EventRepositoryInterface::class);
        $this->handler = new FindByDatesQueryHandler($this->eventRepository);
    }

    public function testHandle(): void
    {
        $startDate = '2023-10-01';
        $endDate = '2023-10-31';
        $expectedEvents = ['event1', 'event2'];

        $this->eventRepository
            ->expects($this->once())
            ->method('findByDateRange')
            ->with($startDate, $endDate)
            ->willReturn($expectedEvents);

        $query = new FindByDatesQuery($startDate, $endDate);
        $result = $this->handler->handle($query);

        $this->assertInstanceOf(FindByDatesQueryResult::class, $result);
        $this->assertIsArray($result->result());
        $this->assertEquals(['events'=>$expectedEvents], $result->result());
    }
}