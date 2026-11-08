<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Shop Home Page
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::resource('cart', CartController::class)->except(['create','edit','show']);

// Admin Dashboard Route
Route::middleware(['auth', 'permission:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('roles',RoleController::class);
    Route::resource('permissions',PermissionController::class);
    Route::resource('users',UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('payment_methods', PaymentMethodController::class);
});

// Customer Dashboard Route
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/shop/index', function () {
        return view('shop.index');
    })->name('customer.dashboard');
    Route::resource('checkout', CheckoutController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
});

// User Profile Routes
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// AUTH ROUTES
require __DIR__.'/auth.php';
