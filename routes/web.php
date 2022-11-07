<?php

use Illuminate\Support\Facades\Route;




Route::get('/', [App\Http\Controllers\ProductsController::class, 'index'])->name('index');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/store/{id}', [App\Http\Controllers\ProductsController::class, 'store'])->name('cart.store');
Route::delete('/cart/delete/{id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('cart.destroy');

Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkoutPost'])->name('checkout');

Route::middleware(['admin'])->group(function () {
    Route::get('/products', [App\Http\Controllers\AdminProductsController::class, 'index'])->name('products.index');
    Route::get('/product/create', [App\Http\Controllers\AdminProductsController::class, 'create'])->name('product.create');
    Route::post('/product/store', [App\Http\Controllers\AdminProductsController::class, 'store'])->name('product.store');
    Route::delete('/products/{id}', [App\Http\Controllers\AdminProductsController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/edit/{id}', [App\Http\Controllers\AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}', [App\Http\Controllers\AdminProductsController::class, 'update'])->name('product.update');

    Route::get('/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders.index')->middleware('admin');
    Route::get('/order/{id}', [App\Http\Controllers\OrdersController::class, 'show'])->name('order.show')->middleware('admin');
});

Route::get('/app', [App\Http\Controllers\ProductsController::class, 'indexApp']);

Route::get('check-csrf', function() {
    return response()->json(csrf_token());
});

//Route::get('/', function() {
//    return view('appp');
//})->name('home');


Auth::routes();



