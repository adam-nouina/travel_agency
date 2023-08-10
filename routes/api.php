<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::apiResource('products',ProductController::class);

Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('search', [ProductController::class, 'search']);

Route::get('citys', [CityController::class, 'index'])->name('citys.index');