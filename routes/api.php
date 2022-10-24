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

Route::get('/app', [App\Http\Controllers\IndexController::class, 'indexApp'])->name('indexApp');
Route::get('/app-index', [App\Http\Controllers\IndexController::class, 'indexspa']);
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products')->middleware('admin');
