<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Application\Client\Query\GetClientPasswordQuery\GetClientPasswordQueryResult;
use App\AuthContext\Application\User\Service\CreateGrantPasswordTokenService;
use App\AuthContext\Infrastructure\QueryBus\QueryBusInterface;
use App\AuthContext\Infrastructure\User\Http\CreateUserTokenController;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CreateUserTokenControllerTest extends TestCase
{
    /** @var QueryBusInterface|(QueryBusInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(QueryBusInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $queryBus;
    /** @var CreateGrantPasswordTokenService|(CreateGrantPasswordTokenService&object&\PHPUnit\Framework\MockObject\MockObject)|(CreateGrantPasswordTokenService&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $createGrantPasswordTokenService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = $this->createMock(QueryBusInterface::class);
        $this->createGrantPasswordTokenService = $this->createMock(CreateGrantPasswordTokenService::class);
    }

    public function testCreateTokenIsSuccess()
    {
        $this->queryBus
            ->expects($this->once())
            ->method('ask')
            ->willReturn(
                new GetClientPasswordQueryResult(
                    ['client_id' => 'client_id', 'client_secret' => 'client_secret']
                )
            );

        $this->createGrantPasswordTokenService
            ->expects($this->once())
            ->method('execute')
            ->willReturn(['token' => 'token']);

        $request = new Request();
        $request->query->add(['email' => 'email']);
        $request->query->add(['password' => 'password']);

        $controller = new CreateUserTokenController($this->queryBus, $this->createGrantPasswordTokenService);

        $response = $controller->createToken($request);

        $this->assertEquals('{"token":"token"}', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}