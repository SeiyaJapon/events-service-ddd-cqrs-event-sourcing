<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Application\User\Query\FindByIdQuery;

use App\AuthContext\Application\User\Query\FindUserByIdQuery\FindByIdQuery;
use App\AuthContext\Application\User\Query\FindUserByIdQuery\FindByIdQueryHandler;
use App\AuthContext\Application\User\Query\FindUserByIdQuery\FindByIdQueryResponse;
use App\AuthContext\Domain\User\User;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FindByIdQueryTest extends TestCase
{
    /** @var UserRepositoryInterface|(UserRepositoryInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(UserRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $userRepository;
    private FindByIdQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->handler = new FindByIdQueryHandler($this->userRepository);
    }

    public function testHandlerSuccess()
    {
        $userId = new UserId(Uuid::uuid4()->toString());

        $this->userRepository
            ->expects($this->once())
            ->method('findById')
            ->with($userId)
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

        $query = new FindByIdQuery($userId);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(FindByIdQueryResponse::class, $result);
        $this->assertEquals('name', $result->result()['name']);
        $this->assertEquals('email@email.com', $result->result()['email']);
    }
}