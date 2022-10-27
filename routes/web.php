<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/index', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/add-to-cart/{id}', [App\Http\Controllers\ProductsController::class, 'store'])->name('addToCart');
Route::get('/remove-from-cart/{id}', [App\Http\Controllers\ProductsController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkoutPost'])->name('checkout');

Route::middleware(['admin'])->group(function () {
    Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products');
    Route::get('/products/{product}', [App\Http\Controllers\ProductsController::class, 'create']);
    Route::get('/AddProduct', [App\Http\Controllers\ProductsController::class, 'add']);
    Route::put('/Add', [App\Http\Controllers\ProductsController::class, 'addProduct'])->name('AddProduct');
    Route::get('/delete/{id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('deleteProduct');
    Route::get('/updateProduct/{id}', [App\Http\Controllers\ProductsController::class, 'updateProduct'])->name('updateProduct');
    Route::put('/update/{id}', [App\Http\Controllers\ProductsController::class, 'update'])->name('update');
});

Route::get('/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders')->middleware('admin');
Route::get('/orders/{order}', [App\Http\Controllers\OrdersController::class, 'show'])->name('order')->middleware('admin');

Auth::routes();


Route::get('/app', [App\Http\Controllers\IndexController::class, 'indexApp'])->name('indexApp');
Route::get('/app-index', [App\Http\Controllers\IndexController::class, 'indexspa']);
Route::get('/app-add-to-cart/{id}', [App\Http\Controllers\ProductsController::class, 'store'])->name('addToCart');
Route::get('/remove-from-cart/{id}', [App\Http\Controllers\ProductsController::class, 'removeFromCart'])->name('removeFromCart');

