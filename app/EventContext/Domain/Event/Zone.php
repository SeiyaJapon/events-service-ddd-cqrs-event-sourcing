<?php

declare (strict_types=1);

namespace App\EventContext\Domain\Event;


use App\EventContext\Domain\AggregateRoot;

class Zone extends AggregateRoot
{
    private string $id;
    private string $eventId;
    private string $name;
    private int $capacity;
    private float $price;
    private bool $numbered;

    public function __construct(
        string $id,
        string $eventId,
        string $name,
        int $capacity,
        float $price,
        bool $numbered
    ) {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->name = $name;
        $this->capacity = $capacity;
        $this->price = $price;
        $this->numbered = $numbered;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function setEventId(string $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function isNumbered(): bool
    {
        return $this->numbered;
    }

    public function setNumbered(bool $numbered): void
    {
        $this->numbered = $numbered;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'event_id' => $this->eventId,
            'name' => $this->name,
            'capacity' => $this->capacity,
            'price' => $this->price,
            'numbered' => $this->numbered
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['event_id'],
            $data['name'],
            $data['capacity'],
            $data['price'],
            $data['numbered']
        );
    }
}