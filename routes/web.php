<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CommissionController as AdminCommissionController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// ============================================================
// PUBLIC ROUTES
// ============================================================
Route::get('/', [ProductController::class, 'landing'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// ============================================================
// AUTH ROUTES
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// ============================================================
// CUSTOMER ROUTES (harus login)
// ============================================================
Route::middleware('auth')->group(function () {
    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    });

    // Wishlist
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/toggle/{product}', [WishlistController::class, 'toggle'])->name('toggle');
    });

    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');

        // RajaOngkir AJAX
        Route::post('/shipping-cost', [CheckoutController::class, 'shippingCost'])->name('shipping-cost');
        Route::get('/destinations', [CheckoutController::class, 'destinations'])->name('destinations');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });

    // Commission
    Route::prefix('commission')->name('commission.')->group(function () {
        Route::get('/', [CommissionController::class, 'index'])->name('index');
        Route::get('/create', [CommissionController::class, 'create'])->name('create');
        Route::post('/', [CommissionController::class, 'store'])->name('store');
        Route::get('/{commission}', [CommissionController::class, 'show'])->name('show');
    });

    // Review
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// ============================================================
// MIDTRANS CALLBACK (no CSRF — dikecualikan di VerifyCsrfToken)
// ============================================================
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])->name('midtrans.callback');

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class);

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
    });

    // Users
    Route::resource('users', AdminUserController::class)->except(['create', 'store']);

    // Commissions
    Route::prefix('commissions')->name('commissions.')->group(function () {
        Route::get('/', [AdminCommissionController::class, 'index'])->name('index');
        Route::get('/{commission}', [AdminCommissionController::class, 'show'])->name('show');
        Route::patch('/{commission}/status', [AdminCommissionController::class, 'updateStatus'])->name('update-status');
    });

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminReviewController::class, 'index'])->name('index');
        Route::delete('/{review}', [AdminReviewController::class, 'destroy'])->name('destroy');
    });
});