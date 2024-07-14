<?php

declare(strict_types=1);

namespace Tests\Unit\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery;

use App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQuery;
use App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQueryHandler;
use App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQueryResponse;
use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GeneratePasswordGrantClientAccessTokenQueryTest extends TestCase
{
    /** @var UserRepositoryInterface|(UserRepositoryInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(UserRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $userRepository;
    private GeneratePasswordGrantClientAccessTokenQueryHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->handler = new GeneratePasswordGrantClientAccessTokenQueryHandler($this->userRepository);
    }

    public function testHandlerSuccess()
    {
        $userId = Uuid::uuid4()->toString();
        $accessToken = 'generated_access_token';

        $this->userRepository
            ->expects($this->once())
            ->method('createToken')
            ->with(new UserId($userId), null)
            ->willReturn($accessToken);

        $query = new GeneratePasswordGrantClientAccessTokenQuery($userId);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(GeneratePasswordGrantClientAccessTokenQueryResponse::class, $result);
        $this->assertEquals($accessToken, $result->result()['access_token']);
    }
}
