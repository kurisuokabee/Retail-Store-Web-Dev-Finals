<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', function (){
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard', ['user' => Auth::user()]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resources([
        'customers' => CustomerController::class,
    ]);
    
    // Product browsing routes
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
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');

//Admin Routes

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
}); 

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('suppliers', SupplierController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('inventory', InventoryController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('orders', AdminOrderController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

