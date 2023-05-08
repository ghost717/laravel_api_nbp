<?php

namespace App\Providers;

use App\Services\ApiIntegration;
use App\Services\CurrencyService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CurrencyRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrencyService::class, function ($app) {
            return new CurrencyService(
                $app->make(CurrencyRepository::class),
                $app->make(ApiIntegration::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
