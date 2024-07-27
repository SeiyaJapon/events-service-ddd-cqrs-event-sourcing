<?php

declare(strict_types=1);

namespace App\AuthContext\Domain\ValueObjects\Single;

abstract class Id
{
    abstract public function getId();

    abstract public static function fromString(string $string): Id;

    abstract public function getHumanReadableId(): string;
}
