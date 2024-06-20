<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/pump-status', [OrderController::class, 'getPumpStatus']);
Route::post('orders', [OrderController::class, 'create']);
Route::post('order', [OrderController::class, 'order']);
Route::post('/save-status', [OrderController::class, 'saveStatus']);