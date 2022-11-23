<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [App\Http\Controllers\ProductController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('cart.destroy');

Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout');

Route::middleware(['admin'])->group(function () {
    Route::get('/products', [App\Http\Controllers\AdminProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\AdminProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\AdminProductsController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [App\Http\Controllers\AdminProductsController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{product}/edit', [App\Http\Controllers\AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\AdminProductsController::class, 'update'])->name('products.update');

    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/order/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
});

Route::get('/main', [App\Http\Controllers\ProductController::class, 'main']);

Auth::routes();

Route::get('/check-csrf', function() {
    return response()->json(csrf_token());
});
