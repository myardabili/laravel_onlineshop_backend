<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\AddressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::get('/categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);

Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index']);

Route::apiResource('addresses', App\Http\Controllers\Api\AddressController::class)->middleware('auth:sanctum');

Route::post('/order', [App\Http\Controllers\Api\OrderController::class, 'order'])->middleware('auth:sanctum');

Route::post('/callback', [App\Http\Controllers\Api\CallbackController::class, 'callback']);

Route::get('/order/status/{id}', [App\Http\Controllers\Api\OrderController::class, 'checkPaymentStatus'])->middleware('auth:sanctum');

Route::post('/update-fcm', [\App\Http\Controllers\Api\AuthController::class, 'updateFcmId'])->middleware('auth:sanctum');

Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'getOrderByUser'])->middleware('auth:sanctum');

Route::get('/order/{id}', [\App\Http\Controllers\Api\OrderController::class, 'getOrderById'])->middleware('auth:sanctum');

Route::get('/product/{id}', [\App\Http\Controllers\Api\ProductController::class, 'getProductById']);

Route::get('products/search', [App\Http\Controllers\Api\ProductController::class, 'search']);
