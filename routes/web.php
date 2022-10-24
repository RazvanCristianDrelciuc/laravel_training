<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/index', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/add-to-cart/{id}', [App\Http\Controllers\ProductsController::class, 'store'])->name('addToCart');
Route::get('/remove-from-cart/{id}', [App\Http\Controllers\ProductsController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkoutPost'])->name('checkout');

Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products')->middleware('admin');
//Route::get('/product/{id}', [App\Http\Controllers\ProductsController::class, 'create']);
Route::get('/products/{product}', [App\Http\Controllers\ProductsController::class, 'create'])->middleware('admin');
Route::get('/AddProduct', [App\Http\Controllers\ProductsController::class, 'add'])->middleware('admin');
Route::put('/Add', [App\Http\Controllers\ProductsController::class, 'addProduct'])->name('AddProduct')->middleware('admin');

Route::get('/delete/{id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('deleteProduct');
Route::get('/updateProduct/{id}', [App\Http\Controllers\ProductsController::class, 'updateProduct'])->name('updateProduct');
//Route::post('/updateProduct/{id}', [App\Http\Controllers\ProductsController::class, 'update'])->name('update');
Route::put('/update/{id}', [App\Http\Controllers\ProductsController::class, 'update'])->name('update')->middleware('admin');

Route::get('/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders')->middleware('admin');
Route::get('/orders/{order}', [App\Http\Controllers\OrdersController::class, 'show'])->name('order')->middleware('admin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/app', [App\Http\Controllers\IndexController::class, 'indexApp'])->name('indexApp');
Route::get('/app-index', [App\Http\Controllers\IndexController::class, 'indexspa']);
Route::get('/app-add-to-cart/{id}', [App\Http\Controllers\ProductsController::class, 'store'])->name('addToCart');
Route::get('/remove-from-cart/{id}', [App\Http\Controllers\ProductsController::class, 'removeFromCart'])->name('removeFromCart');

