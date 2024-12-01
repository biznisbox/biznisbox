<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Laravel\Passport\Passport;
use App\Utils\CustomAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::useAccessTokenEntity(CustomAccessToken::class);
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::cookie('token');
    }
}
