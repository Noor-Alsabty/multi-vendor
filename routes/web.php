<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendorsRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Route::middleware(['auth', 'vendor'])->group(function () {

    Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/create', 'create')->name('products.create');
        Route::get('/products/index',  'index')->name('products.index');
        Route::post('/products/store', 'store')->name('products.store');
        Route::put('/products/update/{id}', 'update')->name('products.update');
        Route::get('/products/edit/{id}',  'edit')->name('products.edit');
        Route::delete('/products/destroy/{id}', 'destroy')->name('products.destroy');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('admin.index');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{delete_id}', [CategoryController::class, 'delete'])->name('categories.delete');
});

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/vendors-requests/index', [VendorsRequestController::class, 'index'])->name('vendors-requests.index');
    Route::get('/vendors-requests/create', [VendorsRequestController::class, 'create'])->name('vendors-requests.create');
    Route::post('/vendors-requests/store', [VendorsRequestController::class, 'store'])->name('vendors-requests.store');
});
