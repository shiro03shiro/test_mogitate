<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/detail/{productId}', [ProductController::class, 'detail'])->name('products.detail');
Route::get('/products/{productId}/update', [ProductController::class, 'edit'])->name('products.update.edit');
Route::put('/products/{productId}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/register', [ProductController::class, 'register'])->name('products.register');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::delete('/products/{productId}/delete', [ProductController::class, 'delete'])->name('products.delete');