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
        // Inversão de dependência para PrinterService
        $this->app->bind(\App\Services\interfaces\PrinterServiceInterface::class, \App\Services\PrinterService::class);
        // Inversão de dependência para PrinterRepository
        $this->app->bind(\App\Repositories\interfaces\PrinterRepositoryInterface::class, \App\Repositories\PrinterRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
