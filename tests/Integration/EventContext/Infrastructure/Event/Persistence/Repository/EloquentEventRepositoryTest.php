<?php

declare(strict_types=1);

namespace Tests\Integration\EventContext\Infrastructure\Event\Persistence\Repository;

use App\EventContext\Domain\Event\Event;
use App\EventContext\Domain\Event\Repositories\ZoneRepositoryInterface;
use App\EventContext\Infrastructure\Event\Persistence\Repository\EloquentEventRepository;
use App\EventContext\Infrastructure\Event\Services\EventDispatcherService;
use App\Models\Event as EventModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class EloquentEventRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @var MockObject|EventDispatcherService */
    private $eventDispatcherService;

    /** @var MockObject|ZoneRepositoryInterface */
    private $zoneRepository;

    /** @var EloquentEventRepository */
    private $eventRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventDispatcherService = $this->createMock(EventDispatcherService::class);
        $this->zoneRepository = $this->createMock(ZoneRepositoryInterface::class);
        $this->eventRepository = new EloquentEventRepository($this->eventDispatcherService, $this->zoneRepository);
    }

    public function testFindById(): void
    {
        $eventModel = new EventModel();
        $eventModel->id = '1';
        $eventModel->title = 'Test Event';
        $eventModel->start_date = '2024-01-01';
        $eventModel->start_time = '12:00:00';
        $eventModel->end_date = '2024-01-01';
        $eventModel->end_time = '14:00:00';
        $eventModel->save();

        Cache::shouldReceive('remember')
            ->once()
            ->andReturnUsing(function ($key, $ttl, $callback) use ($eventModel) {
                return $callback();
            });

        $result = $this->eventRepository->findById('1');

        $this->assertInstanceOf(Event::class, $result);
        $this->assertEquals('1', $result->getId());
    }

    public function testFindByDateRange(): void
    {
        $eventModel = new EventModel();
        $eventModel->id = '1';
        $eventModel->title = 'Test Event';
        $eventModel->start_date = '2024-01-01';
        $eventModel->start_time = '12:00:00';
        $eventModel->end_date = '2024-01-01';
        $eventModel->end_time = '14:00:00';
        $eventModel->save();

        Cache::shouldReceive('remember')
            ->once()
            ->andReturnUsing(function ($key, $ttl, $callback) use ($eventModel) {
                return $callback();
            });

        EventModel::shouldReceive('whereBetween')
            ->once()
            ->with('start_date', ['2024-01-01', '2024-01-31'])
            ->andReturnSelf();
        EventModel::shouldReceive('paginate')
            ->once()
            ->with(1000, ['*'], 'page', 1)
            ->andReturn(collect([$eventModel])->paginate(1000, ['*'], 'page', 1));

        $this->zoneRepository->expects($this->once())
            ->method('findByEventId')
            ->with('1')
            ->willReturn([]);

        $result = $this->eventRepository->findByDateRange('2024-01-01', '2024-01-31');

        $this->assertIsArray($result['data']);
        $this->assertEquals('1', $result['data'][0]['id']);
    }

    public function testSave(): void
    {
        $event = new Event('1', 'Test Event', '2024-01-01', '12:00:00', '2024-01-01', '14:00:00');

        EventModel::shouldReceive('find')
            ->once()
            ->with('1')
            ->andReturn(null);

        EventModel::shouldReceive('save')
            ->once()
            ->andReturn(true);

        Cache::shouldReceive('put')
            ->once()
            ->with("event_1", $event, 3600)
            ->andReturn(true);

        $this->eventDispatcherService->expects($this->once())
            ->method('dispatchEventCreated')
            ->with($this->anything());

        $this->eventRepository->save($event);
    }
}