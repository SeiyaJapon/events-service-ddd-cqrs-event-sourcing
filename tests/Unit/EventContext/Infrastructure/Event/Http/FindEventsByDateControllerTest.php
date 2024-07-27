<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Infrastructure\Event\Http;

use App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQuery;
use App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQueryResult;
use App\EventContext\Infrastructure\Event\Http\FindEventsByDateController;
use App\EventContext\Infrastructure\QueryBus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Exception;

class FindEventsByDateControllerTest extends TestCase
{
    private MockObject $queryBus;
    private FindEventsByDateController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = $this->createMock(QueryBusInterface::class);
        $this->controller = new FindEventsByDateController($this->queryBus);
    }

    public function testFindEventsByDate(): void
    {
        $request = new Request([
            'startDate' => '2023-10-01',
            'endDate' => '2023-10-31'
        ]);

        $expectedResult = ['event1', 'event2'];

        $this->queryBus
            ->expects($this->once())
            ->method('ask')
            ->with(new FindByDatesQuery('2023-10-01', '2023-10-31'))
            ->willReturn(
                new FindByDatesQueryResult($expectedResult)
            );

        $response = $this->controller->findEventsByDate($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(['events' => $expectedResult], $response->getData(true));
    }

    public function testFindEventsByDateWithException(): void
    {
        $request = new Request([
            'startDate' => '2023-10-01',
            'endDate' => '2023-10-31'
        ]);

        $this->queryBus
            ->expects($this->once())
            ->method('ask')
            ->willThrowException(new Exception('Error message', 500));

        $response = $this->controller->findEventsByDate($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals(['error' => 'Error message'], $response->getData(true));
    }
}