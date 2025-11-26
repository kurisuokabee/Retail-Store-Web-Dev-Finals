<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Customer Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;

// -----------------
// Public Routes
// -----------------

Route::get('/', function () {
    return view('auth/login');
});

// Customer login & registration
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// Admin login (public)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
});

// -----------------
// Authenticated Customer Routes
// -----------------
Route::middleware('auth')->group(function () {
    // // Dashboard
    // Route::get('/dashboard', function () {
    //     return view('dashboard', ['user' => Auth::user()]);
    // })->name('dashboard');

    // Customer CRUD
    Route::resource('customers', CustomerController::class);

    // Product browsing
    Route::get('/products/browse', [ProductController::class, 'browse'])->name('products.browse');
    Route::get('/products/category/{category_id}', [ProductController::class, 'filterByCategory'])->name('products.filterByCategory');
    Route::get('/products/{product_id}/details', [ProductController::class, 'details'])->name('products.details');
    Route::post('/products/{product_id}/add-to-cart', [ProductController::class, 'addToCart'])->name('products.addToCart');
    Route::delete('/products/{product_id}/remove-from-cart', [ProductController::class, 'removeFromCart'])->name('products.removeFromCart');

    // Order routes
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/checkout', [OrderController::class, 'create'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Customer logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// -----------------
// Protected Admin Routes
// -----------------
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD resources
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('orders', AdminOrderController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
