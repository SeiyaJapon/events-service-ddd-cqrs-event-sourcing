<?php

declare(strict_types=1);

namespace App\EventContext\Domain;

use DateTimeImmutable;

abstract class DomainEvent
{
    protected string $id;
    protected string $aggregateId;
    protected array $metadata;
    protected array $data;
    protected DateTimeImmutable $occurredOn;

    public function __construct(
        string $id,
        string $aggregateId,
        array $metadata,
        array $data,
        DateTimeImmutable $occurredOn
    ) {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->metadata = $metadata;
        $this->data = $data;
        $this->occurredOn = $occurredOn;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    abstract public static function getEventName(): string;
    abstract public static function getClassName(): string;
    abstract public static function getVersion(): int;
}
