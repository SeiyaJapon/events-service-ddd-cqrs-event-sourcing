<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Infrastructure\Event\Listeners;

use App\EventContext\Application\Event\Commands\SaveZoneCommand\SaveZoneCommand;
use App\EventContext\Domain\Event\Events\EventCreated;
use App\EventContext\Infrastructure\CommandBus\CommandBusInterface;
use App\EventContext\Infrastructure\Event\Listeners\HandleEventCreated;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class HandleEventCreatedTest extends TestCase
{
    private MockObject $commandBus;
    private HandleEventCreated $listener;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->createMock(CommandBusInterface::class);
        $this->listener = new HandleEventCreated($this->commandBus);
    }

    public function testHandle(): void
    {
        $eventData = [
            'id' => '1',
            'event_id' => '123',
            'name' => 'Zone A',
            'capacity' => 100,
            'price' => 50.0,
            'numbered' => true
        ];

        $eventCreated = $this->createMock(EventCreated::class);
        $eventCreated->method('getData')->willReturn($eventData);

        $this->commandBus
            ->expects($this->once())
            ->method('handle')
            ->with($this->callback(function (SaveZoneCommand $command) use ($eventData) {
                return $command->getZone() === $eventData;
            }));

        $this->listener->handle($eventCreated);
    }
}