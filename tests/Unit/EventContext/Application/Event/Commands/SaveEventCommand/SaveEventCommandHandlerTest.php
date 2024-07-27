<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Application\Event\Commands\SaveEventCommand;

use App\EventContext\Application\Event\Commands\SaveEventCommand\SaveEventCommand;
use App\EventContext\Application\Event\Commands\SaveEventCommand\SaveEventCommandHandler;
use App\EventContext\Domain\Event\Event;
use App\EventContext\Domain\Event\Repositories\EventRepositoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SaveEventCommandHandlerTest extends TestCase
{
    private MockObject $eventRepository;
    private SaveEventCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventRepository = $this->createMock(EventRepositoryInterface::class);
        $this->handler = new SaveEventCommandHandler($this->eventRepository);
    }

    public function testHandle(): void
    {
        $eventData = [
            '@attributes' => [
                'event_id' => '123',
                'event_start_date' => '2023-10-01',
                'sell_from' => '2023-09-01',
                'event_end_date' => '2023-10-02',
                'sell_to' => '2023-09-30'
            ],
            'title' => 'Sample Event',
            'zone' => [
                [
                    '@attributes' => [
                        'zone_id' => '1',
                        'capacity' => 100,
                        'name' => 'Zone A',
                        'price' => 50.0,
                        'numbered' => 'true'
                    ]
                ],
                [
                    '@attributes' => [
                        'zone_id' => '2',
                        'capacity' => 200,
                        'name' => 'Zone B',
                        'price' => 75.0,
                        'numbered' => 'false'
                    ]
                ]
            ]
        ];

        $event = Event::fromArray($eventData);

        $this->eventRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->equalTo($event));

        $command = new SaveEventCommand($eventData);
        $this->handler->handle($command);
    }
}
