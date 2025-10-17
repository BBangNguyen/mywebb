<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\admin\user\LoginController;
use App\Http\Controllers\admin\MainController;
use App\Http\Controllers\admin\MenuController;

Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/increase', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('processCheckout');
Route::get('/admin/user/login', [LoginController::class, 'index'])->name('login');
Route::post('/admin/user/login/store', [LoginController::class, 'store']);

Route::middleware('auth')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('/main', [MainController::class, 'index']);
        Route::get('/', [MainController::class, 'index'])->name('admin');

        Route::prefix('menus')->group(function(){
            Route::get('/add', [MenuController::class, 'create']);
            Route::post('/store', [MenuController::class, 'store']);
            Route::get('/list', [MenuController::class, 'list']);
            Route::get('/edit/{id}', [MenuController::class, 'edit']);
            Route::post('/update/{id}', [MenuController::class, 'update']);
            Route::delete('/delete/{id}', [MenuController::class, 'delete']);
        });
    });
});



