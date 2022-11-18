<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {

    Route::get('index', [App\Http\Controllers\ProductController::class, 'index']);
    Route::get('cart', [App\Http\Controllers\CartController::class, 'index']);

//    Route::post('cart/store/{id}', [App\Http\Controllers\ProductController::class, 'store']);
//    Route::delete('cart/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);

    Route::get('products', [App\Http\Controllers\AdminProductsController::class, 'index']);
    Route::post('checkout', [App\Http\Controllers\CheckoutController::class, 'checkoutPost']);

    Route::delete('products/{id}', [App\Http\Controllers\AdminProductsController::class, 'destroy']);
    Route::post('products/edit/{id}', [App\Http\Controllers\AdminProductsController::class, 'edit']);

});
Route::group(['middleware' => 'api'], function () {
Route::get('/sanctum/csrf-cookie', [App\Http\Controllers\ProductController::class, 'store']);
Route::post('cart/store/{id}', [App\Http\Controllers\ProductController::class, 'store']);
Route::delete('cart/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);
//
});
Route::get('/sanctum/csrf-cookie', function() {
    return response()->json(csrf_token());
});
