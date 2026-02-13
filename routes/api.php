<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\KanbanBoardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PrintersController;
use App\Http\Controllers\ProductGroupsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\BudgetItemsController;
use App\Http\Controllers\ServiceOrdersController;
use App\Http\Controllers\ServiceOrderItemsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/kanban-boards', [KanbanBoardController::class, 'index']);
    Route::get('/kanban-boards/{id}', [KanbanBoardController::class, 'show']);
    Route::post('/kanban-boards', [KanbanBoardController::class, 'store']);
    Route::put('/kanban-boards/{id}', [KanbanBoardController::class, 'update']);
    Route::delete('/kanban-boards/{id}', [KanbanBoardController::class, 'destroy']);

    Route::get('/printers', [PrintersController::class, 'index']);
    Route::get('/printers/{id}', [PrintersController::class, 'show']);
    Route::post('/printers', [PrintersController::class, 'store']);
    Route::delete('/printers/{id}', [PrintersController::class, 'destroy']);

    Route::get('/clients', [ClientsController::class, 'index']);
    Route::get('/clients/{id}', [ClientsController::class, 'show']);
    Route::post('/clients', [ClientsController::class, 'store']);
    Route::delete('/clients/{id}', [ClientsController::class, 'destroy']);

    Route::get('/products/{id}', [ProductsController::class, 'show']);
    Route::post('/products', [ProductsController::class, 'store']);
    Route::get('/products', [ProductsController::class, 'index']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy']);

    Route::get('/product-groups', [ProductGroupsController::class, 'index']);
    Route::get('/product-groups/{id}', [ProductGroupsController::class, 'show']);
    Route::post('/product-groups', [ProductGroupsController::class, 'store']);
    Route::put('/product-groups/{id}', [ProductGroupsController::class, 'update']);
    Route::delete('/product-groups/{id}', [ProductGroupsController::class, 'destroy']);

    Route::get('/service-orders', [ServiceOrdersController::class, 'index']);
    Route::get('/service-orders/{id}', [ServiceOrdersController::class, 'show']);
    Route::post('/service-orders', [ServiceOrdersController::class, 'store']);
    Route::put('/service-orders/{id}', [ServiceOrdersController::class, 'update']);
    Route::delete('/service-orders/{id}', [ServiceOrdersController::class, 'destroy']);

    Route::get('/service-order-items', [ServiceOrderItemsController::class, 'index']);
    Route::get('/service-order-items/{id}', [ServiceOrderItemsController::class, 'show']);
    Route::post('/service-order-items', [ServiceOrderItemsController::class, 'store']);
    Route::put('/service-order-items/{id}', [ServiceOrderItemsController::class, 'update']);
    Route::delete('/service-order-items/{id}', [ServiceOrderItemsController::class, 'destroy']);

    Route::get('/budget-items', [BudgetItemsController::class, 'index']);
    Route::get('/budget-items/{id}', [BudgetItemsController::class, 'show']);
    Route::post('/budget-items', [BudgetItemsController::class, 'store']);
    Route::put('/budget-items/{id}', [BudgetItemsController::class, 'update']);
    Route::delete('/budget-items/{id}', [BudgetItemsController::class, 'destroy']);
});

