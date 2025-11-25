<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
