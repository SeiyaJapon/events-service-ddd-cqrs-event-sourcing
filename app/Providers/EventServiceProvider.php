<?php

declare (strict_types=1);

namespace App\Providers;

use App\EventContext\Domain\Event\Events\EventCreated;
use App\EventContext\Domain\Event\Events\EventUpdated;
use App\EventContext\Domain\Event\Events\EventValidated;
use App\EventContext\Infrastructure\Event\Listeners\HandleEventCreated;
use App\EventContext\Infrastructure\Event\Listeners\SaveEventToDatabase;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EventValidated::class => [
            SaveEventToDatabase::class,
        ],
        EventCreated::class => [
            HandleEventCreated::class,
        ],
        EventUpdated::class => [
            HandleEventCreated::class,
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
