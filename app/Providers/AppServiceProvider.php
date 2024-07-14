<?php

namespace App\Providers;

use App\AuthContext\Domain\Client\ClientInterface;
use App\AuthContext\Domain\User\UserRepositoryInterface;
use App\AuthContext\Infrastructure\Client\Persistence\Repository\ClientPassport;
use App\AuthContext\Infrastructure\User\Persistence\Repository\EloquentUserRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('files', function () {
            return new Filesystem();
        });
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(ClientInterface::class, ClientPassport::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
