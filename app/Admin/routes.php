<?php

use App\Admin\Controllers\BrandController;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\HomeController;
use App\Admin\Controllers\OrderController;
use App\Admin\Controllers\ProductController;
use App\Admin\Controllers\TagController;
use App\Admin\Controllers\UserController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', [HomeController::class, 'index'])->name('home');
    $router->resource('/data/brand', BrandController::class);
    $router->resource('/data/tag', TagController::class);
    $router->resource('/data/category', CategoryController::class);
    $router->resource('/data/product', ProductController::class);
    $router->resource('/user', UserController::class);
    $router->resource('/order', OrderController::class);

});
