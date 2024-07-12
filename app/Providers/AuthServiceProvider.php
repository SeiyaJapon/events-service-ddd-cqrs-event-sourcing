<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Passport::ignoreRoutes();

        Passport::tokensExpireIn(now()->addDay(1));
        Passport::refreshTokensExpireIn(now()->addDay(30));
        Passport::personalAccessTokensExpireIn(now()->addMonth(6));

        Passport::tokensCan([
            'access-user-admin' => 'Access of User Admin Area',
        ]);

        Passport::enablePasswordGrant();
    }
}

