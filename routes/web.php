<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\StoreController;
use  App\Http\Controllers\dashboardController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\CategoryController;

Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');

Route::controller(ProductController::class)->group(function () {
    Route::get('/products/create', 'create')->name('products.create');
    Route::get('/products',  'index')->name('products.index');
    Route::post('/products/store', 'store')->name('products.store');
    Route::put('/products/update/{product}', 'update')->name('products.update');
    Route::get('/products/edit/{product}',  'edit')->name('products.edit');
    Route::delete('/products/destroy/{product}', 'destroy')->name('products.destroy');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
});
Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('admin.index');
// 
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{delete_id}', [CategoryController::class, 'delete'])->name('categories.delete');
