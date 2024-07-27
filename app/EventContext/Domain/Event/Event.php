<?php

declare(strict_types=1);

namespace App\EventContext\Domain\Event;

use App\EventContext\Domain\AggregateRoot;
use App\EventContext\Domain\Event\Events\EventValidated;

class Event extends AggregateRoot
{
    private string $id;
    private string $title;
    private string $startDate;
    private string $startTime;
    private string $endDate;
    private string $endTime;
    private array $zones = [];

    public function __construct(
        string $id,
        string $title,
        string $startDate,
        string $startTime,
        string $endDate,
        string $endTime
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->startDate = $startDate;
        $this->startTime = $startTime;
        $this->endDate = $endDate;
        $this->endTime = $endTime;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function setEndTime(string $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function addZone(Zone $zone): void
    {
        $this->zones[] = $zone;
    }

    public function getZones(): array
    {
        return $this->zones;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'zones' => array_map(fn(Zone $zone) => $zone->toArray(), $this->zones)
        ];
    }

    public static function fromArray(array $data): self
    {
        $event = new self(
            $data['@attributes']['event_id'],
            $data['title'],
            $data['@attributes']['event_start_date'],
            $data['@attributes']['sell_from'],
            $data['@attributes']['event_end_date'],
            $data['@attributes']['sell_to']
        );

        foreach ($data['zone'] as $zoneData) {
            $event->addZone(Zone::fromArray(
                [
                    'id' => $zoneData['@attributes']['zone_id'],
                    'event_id' => $data['@attributes']['event_id'],
                    'capacity' => intval($zoneData['@attributes']['capacity']),
                    'name' => $zoneData['@attributes']['name'],
                    'price' => floatval($zoneData['@attributes']['price']),
                    'numbered' => $zoneData['@attributes']['numbered'] === 'true'
                ]
            ));
        }

        return $event;
    }

    public static function isValid(array $event): bool
    {
        return isset($event['@attributes']['base_event_id']) &&
               isset($event['@attributes']['sell_mode']) &&
               "online" === $event['@attributes']['sell_mode'] &&
               isset($event['@attributes']['title']) &&
               isset($event['event']['@attributes']['event_start_date']) &&
               isset($event['event']['@attributes']['event_end_date']) &&
               isset($event['event']['@attributes']['event_id']) &&
               isset($event['event']['@attributes']['sell_from']) &&
               isset($event['event']['@attributes']['sell_to']) &&
               isset($event['event']['@attributes']['sold_out']) &&
               isset($event['event']['zone']);
    }

    public function validate(): void
    {
        if (self::isValid($this->toArray())) {
            $this->record(EventValidated::create(
                $this->id,
                [],
                [
                    'title' => $this->title,
                    'start_date' => $this->startDate,
                    'start_time' => $this->startTime,
                    'end_date' => $this->endDate,
                    'end_time' => $this->endTime,
                    'zones' => array_map(fn(Zone $zone) => $zone->toArray(), $this->zones)
                ]
            ));
        }
    }
}