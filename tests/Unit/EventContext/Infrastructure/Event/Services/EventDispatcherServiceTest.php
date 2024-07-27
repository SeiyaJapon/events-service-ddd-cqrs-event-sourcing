<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Infrastructure\Event\Services;

use App\EventContext\Domain\Event\Events\EventCreated;
use App\EventContext\Domain\Event\Events\EventUpdated;
use App\EventContext\Domain\Event\Events\EventValidated;
use App\EventContext\Infrastructure\Event\Services\EventDispatcherService;
use Illuminate\Contracts\Events\Dispatcher;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class EventDispatcherServiceTest extends TestCase
{
    private MockObject $dispatcher;
    private EventDispatcherService $eventDispatcherService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dispatcher = $this->createMock(Dispatcher::class);
        $this->eventDispatcherService = new EventDispatcherService($this->dispatcher);
    }

    public function testDispatchEventValidated(): void
    {
        $eventData = [
            '@attributes' => ['base_event_id' => '123'],
            'event' => ['id' => '1', 'name' => 'Event A']
        ];

        $this->dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EventValidated::class));

        $this->eventDispatcherService->dispatchEventValidated($eventData);
    }

    public function testDispatchEventCreated(): void
    {
        $eventData = [
            'id' => '1',
            'name' => 'Event A'
        ];

        $this->dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EventCreated::class));

        $this->eventDispatcherService->dispatchEventCreated($eventData);
    }

    public function testDispatchEventUpdated(): void
    {
        $eventData = [
            'id' => '1',
            'name' => 'Event A'
        ];

        $this->dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EventUpdated::class));

        $this->eventDispatcherService->dispatchEventUpdated($eventData);
    }
}