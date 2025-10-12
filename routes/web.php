<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Category routes
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('categories.toggle-featured');
    Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulk-action');

    // Product routes
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::post('products/upload-image', [ProductController::class, 'uploadImage'])->name('products.upload-image');
    Route::delete('products/delete-image', [ProductController::class, 'deleteImage'])->name('products.delete-image');

    // Order routes
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{order}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
    Route::post('orders/bulk-action', [OrderController::class, 'bulkAction'])->name('orders.bulk-action');
});
