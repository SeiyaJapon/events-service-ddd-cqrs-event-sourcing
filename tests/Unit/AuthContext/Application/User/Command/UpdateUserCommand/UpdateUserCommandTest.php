<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Application\User\Command\UpdateUserCommand;

use App\AuthContext\Application\User\Command\UpdateUserCommand\UpdateUserCommand;
use App\AuthContext\Application\User\Command\UpdateUserCommand\UpdateUserCommandHandler;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UpdateUserCommandTest extends TestCase
{
    /** @var UserRepositoryInterface|(UserRepositoryInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(UserRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $userRepository;
    private UpdateUserCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->handler = new UpdateUserCommandHandler($this->userRepository);
    }

    public function testHandlerSuccess()
    {
        $this->userRepository
            ->expects($this->once())
            ->method('update');

        $command = new UpdateUserCommand('id', 'name', 'email', 'password');

        $this->handler->handle($command);
    }
}