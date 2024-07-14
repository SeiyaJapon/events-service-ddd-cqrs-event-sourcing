<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Domain\User\Exception;

use App\AuthContext\Domain\User\Exception\UserNotFoundException;
use App\AuthContext\Domain\User\UserId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserNotFoundExceptionTest extends TestCase
{
    public function testWithId()
    {
        $userId = new UserId(Uuid::uuid4()->toString());
        $exception = UserNotFoundException::withId($userId);

        $this->assertInstanceOf(UserNotFoundException::class, $exception);
        $this->assertEquals('User with id "' . $userId->value() . '" not found', $exception->getMessage());
        $this->assertEquals(404, $exception->getCode());
    }
}