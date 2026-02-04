<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/detail/{productId}', [ProductController::class, 'detail'])->name('products.detail');
Route::get('/products/register', [ProductController::class, 'register'])->name('products.register');

Route::post('/products', [ProductController::class, 'store'])->name('products.store');