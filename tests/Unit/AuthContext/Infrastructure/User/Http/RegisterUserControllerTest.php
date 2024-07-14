<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Infrastructure\User\Http;

use App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQueryResult;
use App\AuthContext\Infrastructure\CommandBus\CommandBusInterface;
use App\AuthContext\Infrastructure\QueryBus\QueryBusInterface;
use App\AuthContext\Infrastructure\User\Http\RegisterUserController;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class RegisterUserControllerTest extends TestCase
{
    /** @var CommandBusInterface|(CommandBusInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(CommandBusInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $commandBus;
    /** @var QueryBusInterface|(QueryBusInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(QueryBusInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $queryBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->createMock(CommandBusInterface::class);
        $this->queryBus = $this->createMock(QueryBusInterface::class);
    }

    public function testRegisterIsSuccess()
    {
        $this->commandBus
            ->expects($this->once())
            ->method('handle');

        $this->queryBus
            ->expects($this->once())
            ->method('ask')
            ->willReturn(
                new FindUserByEmailAndPasswordQueryResult(
                    ['id' => 'id', 'name' => 'name', 'email' => 'email']
                )
            );

        $request = new Request();
        $request->query->add(['name' => 'name']);
        $request->query->add(['email' => 'email']);
        $request->query->add(['password' => 'password']);

        $controller = new RegisterUserController($this->commandBus, $this->queryBus);

        $response = $controller->register($request);
        $toArray = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey('user', $toArray);
        $this->assertEquals('id', $toArray['user']['id']);
        $this->assertEquals('name', $toArray['user']['name']);
        $this->assertEquals('email', $toArray['user']['email']);
    }
}