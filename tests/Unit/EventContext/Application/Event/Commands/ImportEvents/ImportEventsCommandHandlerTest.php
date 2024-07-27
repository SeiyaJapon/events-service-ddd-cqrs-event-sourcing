<?php

declare (strict_types=1);

namespace Tests\Unit\EventContext\Application\Event\Commands\ImportEvents;

use App\EventContext\Application\Event\Commands\ImportEvents\ImportEventsCommand;
use App\EventContext\Application\Event\Commands\ImportEvents\ImportEventsCommandHandler;
use App\EventContext\Infrastructure\Event\Persistence\Repository\DataThirdPartyEventRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ImportEventsCommandHandlerTest extends TestCase
{
    private MockObject $repository;
    private ImportEventsCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(DataThirdPartyEventRepository::class);
        $this->handler = new ImportEventsCommandHandler($this->repository);
    }

    public function testHandle(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('import')
            ->with('http://example.com/events.json');

        $this->handler->handle(new ImportEventsCommand('http://example.com/events.json'));
    }
}
