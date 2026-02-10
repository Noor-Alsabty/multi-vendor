<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\StoreController;
use  App\Http\Controllers\dashboardController;


Route::get('/', function () {
    return view('dashboard');
});
// 

Route::get('/d', [dashboardController::class, 'index'])->name('dashboard');



// 

Route::get('/store',[StoreController::class,'index'])->name('store.index');

Route::get('/create',[StoreController::class,'create'])->name('store.create');
Route::post('/store',[StoreController::class,'store'])->name('store.store');
Route::get('/store/{store}/edit',[StoreController::class,'edit'])->name('store.edit');
Route::put('/store/{store}',[StoreController::class,'update'])->name('store.update');
Route::get('/show/{store}',[StoreController::class,'show'])->name('store.show');
Route::delete('/delete/{store}',[StoreController::class,'destroy'])->name('store.destroy');
