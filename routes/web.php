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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return '<h1>Hello world</h1>';
});

Route::get('users', function()
{
    return View::make('users');
});



Route::get('/index',[App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::get('/cart',[App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/addToCart/{id}',[App\Http\Controllers\ProductsController::class, 'addToCart'])->name('addToCart');
Route::get('/removeFromCart/{id}',[App\Http\Controllers\ProductsController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/checkout', [App\Http\Controllers\CartController::class,'checkoutPost'])->name('checkout');

Route::get('/products',[App\Http\Controllers\ProductsController::class, 'index'])->name('products');
Route::get('/products/{product}',[App\Http\Controllers\ProductsController::class, 'show']);
Route::get('/product',[App\Http\Controllers\ProductsController::class, 'show']);

Route::get('/delete/{id}',[App\Http\Controllers\ProductsController::class, 'deleteProduct'])->name('deleteProduct');
Route::get('/update',[App\Http\Controllers\ProductsController::class, 'updateProduct'])->name('updateProduct');
Route::get('/delete/{id}',[App\Http\Controllers\ProductsController::class, 'deleteProduct'])->name('deleteProduct');



