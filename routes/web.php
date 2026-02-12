<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\StoreController;
use  App\Http\Controllers\dashboardController;
use App\Http\Controllers\VendorController;

Route::get('/vendor/dashboard',[VendorController::class,'index'])->name('vendor.dashboard');