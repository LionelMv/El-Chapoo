<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderWebController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', [OrderWebController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderWebController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderWebController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/edit', [OrderWebController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrderWebController::class, 'update'])->name('orders.update');
Route::delete('/orders/{order}', [OrderWebController::class, 'destroy'])->name('orders.destroy');
