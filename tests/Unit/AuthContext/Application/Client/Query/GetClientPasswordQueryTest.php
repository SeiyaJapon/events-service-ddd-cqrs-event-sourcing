<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Application\Client\Query;

use App\AuthContext\Application\Client\Query\GetClientPasswordQuery\GetClientPasswordQuery;
use App\AuthContext\Application\Client\Query\GetClientPasswordQuery\GetClientPasswordQueryHandler;
use App\AuthContext\Application\Client\Query\GetClientPasswordQuery\GetClientPasswordQueryResult;
use App\AuthContext\Domain\Client\ClientInterface;
use PHPUnit\Framework\TestCase;

class GetClientPasswordQueryTest extends TestCase
{
    /** @var ClientInterface|(ClientInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(ClientInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $client;
    private GetClientPasswordQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(ClientInterface::class);

        $this->handler = new GetClientPasswordQueryHandler($this->client);
    }

    public function testHandlerSuccess()
    {
        $this->client
            ->expects($this->once())
            ->method('getClient');

        $query = new GetClientPasswordQuery();

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GetClientPasswordQueryResult::class, $result);
        $this->assertIsArray($result->result());
        $this->assertArrayHasKey('client', $result->result());
    }
}