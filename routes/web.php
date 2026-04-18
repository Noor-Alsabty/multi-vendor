<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VendorsRequestController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WelcomeController;

Route::get('/search', [ProductController::class, 'indexsearch'])->name('product.indexsearch');
Route::get('/', [ProductController::class, 'ind'])->name('pro.ind');
Route::get('/products/{id}', [ProductController::class, 'show'])->whereNumber('id')->name('products.show');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/empty-cart', function () {
    return view('carts.empty-cart');
})->name('empty-cart');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Route::middleware(['auth', 'vendor'])->group(function () {

    Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products',  'index')->name('products.index');
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products/store', 'store')->name('products.store');
        Route::put('/products/update/{product}', 'update')->name('products.update');
        Route::get('/products/edit/{product}',  'edit')->name('products.edit');
        Route::delete('/products/destroy/{product}', 'destroy')->name('products.destroy');
        Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::get('/my-wallet', [WalletController::class, 'index'])->name('vendor.wallet');
    });
});
Route::get('/notification/read/{notification_id}', [NotificationController::class, 'read'])->name('notification.read');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/vendors', [AdminController::class, 'allVendors'])->name('vendors.index');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{delete_id}', [CategoryController::class, 'delete'])->name('categories.delete');

    Route::get('/vendors-requests/indexAdmin', [AdminController::class, 'indexAdmin'])->name('vendors-requests.indexAdmin');
    Route::post('/vendors-requests/{id}/verify', [AdminController::class, 'verify'])->name('vendors-requests.verify');

    Route::post('/vendors-requests/{id}/reject', [AdminController::class, 'reject'])->name('vendors-requests.reject');
});


Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/vendors-requests/index', [VendorsRequestController::class, 'index'])->name('vendors-requests.index');
    Route::get('/vendors-requests/create', [VendorsRequestController::class, 'create'])->name('vendors-requests.create');
    Route::post('/vendors-requests/store', [VendorsRequestController::class, 'store'])->name('vendors-requests.store');
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts/store/{variant_id}', [CartItemController::class, 'store'])->name('carts.store');
    Route::delete('/carts/item/{id}',  [CartItemController::class, 'destroy'])->name('carts.destroy');



    Route::get('/checkout', [PaymentController::class, 'showCheckoutPage'])->name('checkout.show');

    // 2. إرسال البيانات إلى Stripe
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');

    // 3. روابط العودة
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});
