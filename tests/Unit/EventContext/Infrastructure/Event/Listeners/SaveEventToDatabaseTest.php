<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Infrastructure\Event\Listeners;

use App\EventContext\Application\Event\Commands\SaveEventCommand\SaveEventCommand;
use App\EventContext\Domain\Event\Events\EventValidated;
use App\EventContext\Infrastructure\CommandBus\CommandBusInterface;
use App\EventContext\Infrastructure\Event\Listeners\SaveEventToDatabase;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SaveEventToDatabaseTest extends TestCase
{
    private MockObject $commandBus;
    private SaveEventToDatabase $listener;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->createMock(CommandBusInterface::class);
        $this->listener = new SaveEventToDatabase($this->commandBus);
    }

    public function testHandle(): void
    {
        $eventData = [
            'id' => '1',
            'name' => 'Event A',
            'date' => '2023-10-01',
            'location' => 'Location A'
        ];

        $eventValidated = $this->createMock(EventValidated::class);
        $eventValidated->method('getData')->willReturn($eventData);

        $this->commandBus
            ->expects($this->once())
            ->method('handle')
            ->with($this->callback(function (SaveEventCommand $command) use ($eventData) {
                return $command->getEventData() === $eventData;
            }));

        $this->listener->handle($eventValidated);
    }
}