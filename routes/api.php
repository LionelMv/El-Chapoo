<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/customer/{customer}', [OrderController::class, 'getCustomerOrders']);
Route::get('/orders', [OrderController::class, 'index']);
