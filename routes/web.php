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

Route::get('/index',[App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::get('/cart',[App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/addToCart/{id}',[App\Http\Controllers\ProductsController::class, 'addToCart'])->name('addToCart');
Route::get('/removeFromCart/{id}',[App\Http\Controllers\ProductsController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/checkout', [App\Http\Controllers\CartController::class,'checkoutPost'])->name('checkout');

Route::get('/products',[App\Http\Controllers\ProductsController::class, 'index'])->name('products');
Route::get('/product/{id}',[App\Http\Controllers\ProductsController::class, 'create']);
Route::get('/products/{product}', [App\Http\Controllers\ProductsController::class,'create']);
Route::get('/AddProduct', [App\Http\Controllers\ProductsController::class,'add']);
Route::put('/Add', [App\Http\Controllers\ProductsController::class,'addProduct'])->name('AddProduct');


Route::get('/delete/{id}',[App\Http\Controllers\ProductsController::class, 'deleteProduct'])->name('deleteProduct');
Route::get('/updateProduct/{id}',[App\Http\Controllers\ProductsController::class, 'updateProduct'])->name('updateProduct');
Route::get('/delete/{id}',[App\Http\Controllers\ProductsController::class, 'deleteProduct'])->name('deleteProduct');
Route::post('/updateProduct/{id}',[App\Http\Controllers\ProductsController::class, 'update'])->name('update');
Route::put('/update/{id}',[App\Http\Controllers\ProductsController::class, 'update'])->name('update');

Route::get('/register',[App\Http\Controllers\RegisterController::class, 'index'])->name('register');
Route::put('/register',[App\Http\Controllers\RegisterController::class, 'registerUser'])->name('registerUser');

Route::get('/loginUser',[App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::put('/login',[App\Http\Controllers\LoginController::class, 'authenticate'])->name('loginUser');

Route::get('/orders',[App\Http\Controllers\OrdersController::class, 'index'])->name('orders');
Route::get('/orders/{order}',[App\Http\Controllers\OrdersController::class, 'viewOrder'])->name('order');
