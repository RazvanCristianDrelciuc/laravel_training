<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\ProductsController::class, 'index'])->name('index');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [App\Http\Controllers\ProductsController::class, 'create'])->name('cart.store');
Route::delete('/cart/remove/{id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('cart.destroy');

Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkoutPost'])->name('checkout');

Route::middleware(['admin'])->group(function () {
    Route::get('/products', [App\Http\Controllers\AdminProductsController::class, 'index'])->name('products.index');
    Route::get('/product/create', [App\Http\Controllers\AdminProductsController::class, 'create'])->name('product.create');
    Route::put('/product/store', [App\Http\Controllers\AdminProductsController::class, 'store'])->name('product.store');
    Route::delete('/products/delete/{id}', [App\Http\Controllers\AdminProductsController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/edit/{id}', [App\Http\Controllers\AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}', [App\Http\Controllers\AdminProductsController::class, 'update'])->name('product.update');

    Route::get('/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders.index')->middleware('admin');
    Route::get('/order/{order}', [App\Http\Controllers\OrdersController::class, 'show'])->name('order.show')->middleware('admin');
});

Auth::routes();



