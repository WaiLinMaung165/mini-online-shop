<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Shop Home Page
Route::get('/', function () {
    if (Auth::check()) {
        /** @var User $user */
        $user = Auth::user();

        if ($user->can('access-admin')) {
            return redirect()->route('admin.dashboard');
        }
    }
    return app(ShopController::class)->index(request());
})->name('shop.index');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::resource('cart', CartController::class)->except(['create', 'edit', 'show']);
Route::resource('wishlist', WishlistController::class);
Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Admin Dashboard Route
Route::middleware(['auth', 'permission:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);

    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('admin/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);

    Route::resource('payment_methods', PaymentMethodController::class);

    Route::get('/orders/export-excel', [OrderStatusController::class, 'exportExcel'])->name('orders.exportExcel');
    Route::resource('orders', OrderStatusController::class);

    Route::resource('coupons', CouponController::class);
});

// Customer Dashboard Route
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/shop/index', function () {
        return view('shop.index');
    })->name('customer.dashboard');

    Route::resource('checkout', CheckoutController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('orders', OrderController::class);

    Route::post('/orders/{order}/received', [OrderController::class, 'markAsCompleted'])->name('order.received');
    Route::get('/orders/{order}/invoiced', [OrderController::class, 'downloadInvoice'])->name('order.invoice');

    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/products/{product}/rate',[RatingController::class,'store'])->name('products.rate');
});

// User Profile Routes
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// AUTH ROUTES
require __DIR__ . '/auth.php';
