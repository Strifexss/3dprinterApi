<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PrintersController;
use App\Http\Controllers\ProductGroupsController;
use App\Http\Controllers\ProductsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/printers', [PrintersController::class, 'index']);
    Route::get('/printers/{id}', [PrintersController::class, 'show']);
    Route::post('/printers', [PrintersController::class, 'store']);
    Route::delete('/printers/{id}', [PrintersController::class, 'destroy']);

    // Rotas de clients
    Route::get('/clients', [ClientsController::class, 'index']);
    Route::get('/clients/{id}', [ClientsController::class, 'show']);
    Route::post('/clients', [ClientsController::class, 'store']);
    Route::delete('/clients/{id}', [ClientsController::class, 'destroy']);

    Route::get('/products/{id}', [ProductsController::class, 'show']);
    Route::post('/products', [ProductsController::class, 'store']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy']);

    Route::get('/product-groups', [ProductGroupsController::class, 'index']);
    Route::get('/product-groups/{id}', [ProductGroupsController::class, 'show']);
    Route::post('/product-groups', [ProductGroupsController::class, 'store']);
    Route::put('/product-groups/{id}', [ProductGroupsController::class, 'update']);
    Route::delete('/product-groups/{id}', [ProductGroupsController::class, 'destroy']);
});

