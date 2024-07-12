<?php

declare (strict_types=1);

namespace App\AuthContext\Application\User\Query\FindUserByIdQuery;

use App\AuthContext\Application\Query\QueryInterface;
use App\AuthContext\Domain\User\UserId;

class FindByIdQuery implements QueryInterface
{
    private UserId $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}