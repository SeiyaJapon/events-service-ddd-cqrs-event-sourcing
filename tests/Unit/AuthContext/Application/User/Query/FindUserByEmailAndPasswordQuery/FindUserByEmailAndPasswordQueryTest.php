<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery;

use App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQuery;
use App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQueryHandler;
use App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQueryResult;
use App\AuthContext\Domain\User\User;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FindUserByEmailAndPasswordQueryTest extends TestCase
{
    /** @var UserRepositoryInterface|(UserRepositoryInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(UserRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $userRepository;
    private FindUserByEmailAndPasswordQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->handler = new FindUserByEmailAndPasswordQueryHandler($this->userRepository);
    }

    public function testHandlerSuccess()
    {
        $this->userRepository
            ->expects($this->once())
            ->method('findByEmailAndPassword')
            ->with('email@email.com', 'password')
            ->willReturn(
                new User(
                    new UserId(Uuid::uuid4()->toString()),
                    'name',
                    'email@email.com',
                    (new \DateTime())->format('Y-m-d H:i:s'),
                    'password',
                    'salt'
                )
            );

        $query = new FindUserByEmailAndPasswordQuery(
            'email@email.com',
            'password'
        );

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(FindUserByEmailAndPasswordQueryResult::class, $result);
        $this->assertArrayHasKey('user', $result->result());
        $this->assertEquals('name', $result->result()['user']['name']);
        $this->assertEquals('email@email.com', $result->result()['user']['email']);
    }
}