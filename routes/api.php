<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/category/get', [CategoryController::class, 'index']);
    Route::get('/category/{slug}', [CategoryController::class, 'show']);

    Route::get('/product/get', [ProductController::class, 'index']);
    Route::get('/product/detail/{slug}', [ProductController::class, 'show']);
    Route::get('/product/get-product-by-category/{slug}', [ProductController::class, 'getProductByCategory']);

    Route::post('/user/login', [AuthController::class, 'login']);
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/user/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/payment/success', [StripeController::class, 'handleSuccess']);
    Route::get('/payment/cancel', [StripeController::class, 'handleCancel']);

    Route::middleware(['auth:sanctum', 'role:admin,user'])->group(function () {
        Route::get('/user/user-details', [AuthController::class, 'user']);
        Route::post('/user/logout', [AuthController::class, 'logout']);
        Route::post('/user/update-user', [AuthController::class, 'updateUser']);

        Route::post('/address/create', [AddressController::class, 'create']);
        Route::put('/address/update/{id}', [AddressController::class, 'update']);
        Route::delete('/address/delete/{id}', [AddressController::class, 'delete']);

        Route::get('/cart/get', [CartController::class, 'get']);
        Route::post('/cart/add', [CartController::class, 'create']);;
        Route::put('/cart/update/{id}', [CartController::class, 'update']);
        Route::delete('/cart/delete/{id}', [CartController::class, 'delete']);

        Route::get('/order/get', [OrderController::class, 'get']);
        Route::post('/order/create', [OrderController::class, 'create']);

        Route::post('/checkout/stripe', [StripeController::class, 'checkout']);
    });
});
