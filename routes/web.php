<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\StoreController;
use  App\Http\Controllers\dashboardController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;

Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');

Route::controller(ProductController::class)->group(function () {
    Route::get('/products/create', 'create')->name('products.create');
    Route::get('/products/index',  'index')->name('products.index');
    Route::post('/products/store', 'store')->name('products.store');
    Route::put('/products/update/{id}', 'update')->name('products.update');
    Route::get('/products/edit/{id}',  'edit')->name('products.edit');
    Route::delete('/products/destroy/{id}', 'destroy')->name('products.destroy');
});
