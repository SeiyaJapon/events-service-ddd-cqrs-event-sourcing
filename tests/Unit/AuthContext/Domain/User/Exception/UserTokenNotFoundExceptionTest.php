<?php

declare (strict_types=1);

namespace Tests\Unit\AuthContext\Domain\User\Exception;

use App\AuthContext\Domain\User\Exception\UserTokenNotFoundException;
use App\AuthContext\Domain\User\UserId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTokenNotFoundExceptionTest extends TestCase
{
    public function testWithId()
    {
        $userId = new UserId(Uuid::uuid4()->toString());
        $exception = UserTokenNotFoundException::withId($userId);

        $this->assertInstanceOf(UserTokenNotFoundException::class, $exception);
        $this->assertEquals(
            'User token for user with id "' . $userId->value() . '" not found', $exception->getMessage()
        );
        $this->assertEquals(404, $exception->getCode());
    }
}