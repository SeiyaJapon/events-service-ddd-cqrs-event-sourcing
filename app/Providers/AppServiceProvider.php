<?php

namespace App\Providers;

use App\EventContext\Domain\Event\Repositories\EventRepositoryInterface;
use App\EventContext\Domain\Event\Repositories\ThirdPartyEventRepositoryInterface;
use App\EventContext\Domain\Event\Repositories\ZoneRepositoryInterface;
use App\EventContext\Infrastructure\Event\Persistence\Repository\DataThirdPartyEventRepository;
use App\EventContext\Infrastructure\Event\Persistence\Repository\EloquentEventRepository;
use App\EventContext\Infrastructure\Event\Persistence\Repository\EloquentZoneRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EventRepositoryInterface::class, EloquentEventRepository::class);
        $this->app->bind(ZoneRepositoryInterface::class, EloquentZoneRepository::class);
        $this->app->bind(ThirdPartyEventRepositoryInterface::class, DataThirdPartyEventRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
