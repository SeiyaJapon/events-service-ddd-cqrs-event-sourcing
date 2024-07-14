<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Application\User\Command\RegisterUserCommand;

use App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommand;
use App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommandHandler;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class RegisterUserCommandHandlerTest extends TestCase
{
    /** @var UserRepositoryInterface|(UserRepositoryInterface&object&\PHPUnit\Framework\MockObject\MockObject)|(UserRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|(object&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject */
    private $userRepository;
    private RegisterUserCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->handler = new RegisterUserCommandHandler($this->userRepository);
    }

    public function testHandlerSuccess()
    {
        $this->userRepository
            ->expects($this->once())
            ->method('save');

        $command = new RegisterUserCommand('name', 'email', 'password');

        $this->handler->handle($command);
    }
}