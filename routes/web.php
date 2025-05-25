<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NavigateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NavigateController::class, 'home'])->name('home');
Route::get('/login', [NavigateController::class, 'login'])->name('login');
Route::get('/shop', [NavigateController::class, 'shop'])->name('shop');
Route::get('/detail', [NavigateController::class, 'detail'])->name('detail');
Route::get('/page-not-found', fn() => view('pages.404'))->name('404');
Route::get('/contact-us', [NavigateController::class, 'contact'])->name('contact');
Route::get('/cart', [NavigateController::class, 'cart'])->name('cart');
Route::get('/blog', [NavigateController::class, 'blog'])->name('blog');
Route::get('/blog-detail', [NavigateController::class, 'blogDetail'])->name('blogDetail');
Route::get('/checkout', [NavigateController::class, 'checkout'])->name('checkout');

//Route::fallback(fn() => redirect()->route('404'));

Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.submit');

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'handleLogout'])->name('logout');
});
