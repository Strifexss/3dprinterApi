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
        $this->app->bind(\App\Services\interfaces\PrinterServiceInterface::class, \App\Services\PrinterService::class);
        $this->app->bind(\App\Repositories\interfaces\PrinterRepositoryInterface::class, \App\Repositories\PrinterRepository::class);
        $this->app->bind(\App\Services\interfaces\ClientServiceInterface::class, \App\Services\ClientService::class);
        $this->app->bind(\App\Repositories\interfaces\ClientRepositoryInterface::class, \App\Repositories\ClientRepository::class);
        $this->app->bind(\App\Services\interfaces\ContactServiceInterface::class, function ($app) {
            return new \App\Services\ContactService($app->make(\App\Repositories\interfaces\ContactRepositoryInterface::class));
        });
        $this->app->bind(\App\Repositories\interfaces\ContactRepositoryInterface::class, function ($app) {
            return new \App\Repositories\ContactRepository();
        });
        $this->app->bind(\App\Services\interfaces\ProductServiceInterface::class, \App\Services\ProductService::class);
        $this->app->bind(\App\Repositories\interfaces\ProductRepositoryInterface::class, \App\Repositories\ProductRepository::class);
        $this->app->bind(\App\Services\interfaces\ProductGroupServiceInterface::class, \App\Services\ProductGroupService::class);
        $this->app->bind(\App\Repositories\interfaces\ProductGroupRepositoryInterface::class, \App\Repositories\ProductGroupRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
