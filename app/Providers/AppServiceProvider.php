<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...existing code...
        $this->app->bind(\App\Services\interfaces\ItemReservationServiceInterface::class, \App\Services\ItemReservationService::class);
        $this->app->bind(\App\Repositories\interfaces\ItemReservationRepositoryInterface::class, \App\Repositories\ItemReservationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
