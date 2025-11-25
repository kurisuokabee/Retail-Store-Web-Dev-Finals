<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
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
    Route::resource('orders', OrderController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
