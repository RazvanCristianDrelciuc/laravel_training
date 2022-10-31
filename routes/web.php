<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\ProductsController::class, 'index'])->name('index');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [App\Http\Controllers\ProductsController::class, 'create'])->name('cart.store');
Route::get('/cart/remove/{id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('cart.destroy');

Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkoutPost'])->name('checkout');

Route::middleware(['admin'])->group(function () {
    Route::get('/products', [App\Http\Controllers\AdminProductsController::class, 'index'])->name('products.index');
    //Route::get('/products/{product}', [App\Http\Controllers\AdminProductsController::class, 'view']);
    Route::get('/products/create', [App\Http\Controllers\AdminProductsController::class, 'create'])->name('product.create');
    Route::put('/products/show', [App\Http\Controllers\AdminProductsController::class, 'show'])->name('product.show');
    Route::get('/products/delete/{id?}', [App\Http\Controllers\AdminProductsController::class, 'destroy'])->name('product.destroy');
    Route::get('/products/edit/{id}', [App\Http\Controllers\AdminProductsController::class, 'edit'])->name('product.edit');
    Route::put('/products/update/{id}', [App\Http\Controllers\AdminProductsController::class, 'update'])->name('product.update');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders')->middleware('admin');
    Route::get('/orders/{order}', [App\Http\Controllers\OrdersController::class, 'show'])->name('order')->middleware('admin');
});

Auth::routes();

//Route::resource('products', AdminProductsController::class)->names([
//    'index' => 'products.index',
//    'show' => 'prodcts.show',
//    'create' => 'prodcts.create',
//    'destroy' => 'prodcts.destroy',
//    'edit' => 'prodcts.edit',
//    'update' => 'prodcts.update',
//]);


