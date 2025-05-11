<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StripeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

//category
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::post('/category', [CategoryController::class, 'store']);
Route::post('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

//product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{slug}', [ProductController::class, 'show']);
Route::post('/product', [ProductController::class, 'store']);
Route::post('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

//auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/payment/success', [StripeController::class, 'handleSuccess']);
Route::get('/payment/cancel', [StripeController::class, 'handleCancel']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/update-user', [AuthController::class, 'updateUser']);

    Route::post('/create-address', [AddressController::class, 'createAddress']);
    Route::post('/update-address/{id}', [AddressController::class, 'updateAddress']);

    Route::get('/get-cart-item', [CartController::class, 'getCartItem']);
    Route::post('/add-cart-item/{id}', [CartController::class, 'addCartItem']);;
    Route::post('/update-cart-item/{id}', [CartController::class, 'updateCartItem']);
    Route::delete('/delete-cart-item/{id}', [CartController::class, 'removeCartItem']);

    Route::post('/payment', [OrderController::class, 'payment']);
    Route::get('/get-order-details', [OrderController::class, 'getOrderDetails']);

    Route::post('/stripe/checkout', [StripeController::class, 'checkout']);
});
