<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Application\Event\Commands\SaveZoneCommand;

use App\EventContext\Application\Event\Commands\SaveZoneCommand\SaveZoneCommand;
use App\EventContext\Application\Event\Commands\SaveZoneCommand\SaveZoneCommandHandler;
use App\EventContext\Domain\Event\Zone;
use App\EventContext\Domain\Event\Repositories\ZoneRepositoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SaveZoneCommandHandlerTest extends TestCase
{
    private MockObject $zoneRepository;
    private SaveZoneCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->zoneRepository = $this->createMock(ZoneRepositoryInterface::class);
        $this->handler = new SaveZoneCommandHandler($this->zoneRepository);
    }

    public function testHandle(): void
    {
        $zoneData = [
            'id' => '1',
            'event_id' => '123',
            'name' => 'Zone A',
            'capacity' => 100,
            'price' => 50.0,
            'numbered' => true
        ];

        $zone = Zone::fromArray($zoneData);

        $this->zoneRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->equalTo($zone));

        $command = $this->createMock(SaveZoneCommand::class);
        $command->method('getZone')->willReturn($zoneData);

        $this->handler->handle($command);
    }
}