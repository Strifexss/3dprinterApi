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
        $this->app->bind(\App\Services\interfaces\BudgetItemServiceInterface::class, \App\Services\BudgetItemService::class);
        $this->app->bind(\App\Services\interfaces\BudgetServiceInterface::class, \App\Services\BudgetService::class);
        $this->app->bind(\App\Services\interfaces\ClientServiceInterface::class, \App\Services\ClientService::class);
        $this->app->bind(\App\Services\interfaces\ContactServiceInterface::class, \App\Services\ContactService::class);
        $this->app->bind(\App\Services\interfaces\ItemReservationServiceInterface::class, \App\Services\ItemReservationService::class);
        $this->app->bind(\App\Services\interfaces\KanbanBoardServiceInterface::class, \App\Services\KanbanBoardService::class);
        $this->app->bind(\App\Services\interfaces\PrinterServiceInterface::class, \App\Services\PrinterService::class);
        $this->app->bind(\App\Services\interfaces\ProductGroupServiceInterface::class, \App\Services\ProductGroupService::class);
        $this->app->bind(\App\Services\interfaces\ProductServiceInterface::class, \App\Services\ProductService::class);
        $this->app->bind(\App\Services\interfaces\ServiceOrderItemServiceInterface::class, \App\Services\ServiceOrderItemService::class);
        $this->app->bind(\App\Services\interfaces\ServiceOrderServiceInterface::class, \App\Services\ServiceOrderService::class);

        $this->app->bind(\App\Repositories\interfaces\BudgetItemRepositoryInterface::class, \App\Repositories\BudgetItemRepository::class);
        $this->app->bind(\App\Repositories\interfaces\BudgetRepositoryInterface::class, \App\Repositories\BudgetRepository::class);
        $this->app->bind(\App\Repositories\interfaces\ClientRepositoryInterface::class, \App\Repositories\ClientRepository::class);
        $this->app->bind(\App\Repositories\interfaces\ContactRepositoryInterface::class, \App\Repositories\ContactRepository::class);
        $this->app->bind(\App\Repositories\interfaces\ItemReservationRepositoryInterface::class, \App\Repositories\ItemReservationRepository::class);
        $this->app->bind(\App\Repositories\interfaces\KanbanBoardRepositoryInterface::class, \App\Repositories\KanbanBoardRepository::class);
        $this->app->bind(\App\Repositories\interfaces\PrinterRepositoryInterface::class, \App\Repositories\PrinterRepository::class);
        $this->app->bind(\App\Repositories\interfaces\ProductGroupRepositoryInterface::class, \App\Repositories\ProductGroupRepository::class);
        $this->app->bind(\App\Repositories\interfaces\ProductRepositoryInterface::class, \App\Repositories\ProductRepository::class);
        $this->app->bind(\App\Repositories\interfaces\ServiceOrderItemRepositoryInterface::class, \App\Repositories\ServiceOrderItemRepository::class);
        $this->app->bind(\App\Repositories\interfaces\ServiceOrderRepositoryInterface::class, \App\Repositories\ServiceOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
