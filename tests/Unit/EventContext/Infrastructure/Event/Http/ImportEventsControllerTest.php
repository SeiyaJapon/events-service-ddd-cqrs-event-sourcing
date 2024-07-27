<?php

declare(strict_types=1);

namespace Tests\Unit\EventContext\Infrastructure\Event\Http;

use App\EventContext\Application\Event\Commands\ImportEvents\ImportEventsCommand;
use App\EventContext\Infrastructure\CommandBus\CommandBusInterface;
use App\EventContext\Infrastructure\Event\Http\ImportEventsController;
use App\EventContext\Infrastructure\Event\Resources\ThirdPartyRoutes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ImportEventsControllerTest extends TestCase
{
    private MockObject $commandBus;
    private ImportEventsController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->createMock(CommandBusInterface::class);
        $this->controller = new ImportEventsController($this->commandBus);
    }

    public function testImportEvents(): void
    {
        $request = new Request(['url' => 'http://example.com/events']);

        $this->commandBus
            ->expects($this->once())
            ->method('handle')
            ->with($this->callback(function (ImportEventsCommand $command) {
                return $command->getUrl() === 'http://example.com/events';
            }));

        $response = $this->controller->importEvents($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(['message' => 'Events imported successfully'], $response->getData(true));
    }

    public function testImportEventsWithDefaultUrl(): void
    {
        $request = new Request();

        $this->commandBus
            ->expects($this->once())
            ->method('handle')
            ->with($this->callback(function (ImportEventsCommand $command) {
                return $command->getUrl() === ThirdPartyRoutes::EVENT_PROVIDER_URL;
            }));

        $response = $this->controller->importEvents($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(['message' => 'Events imported successfully'], $response->getData(true));
    }
}