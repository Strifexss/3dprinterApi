<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PrintersController;


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
});

