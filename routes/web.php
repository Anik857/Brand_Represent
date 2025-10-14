<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
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
    // Dashboard - requires view dashboard permission
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view dashboard');
    
    // Profile Routes - accessible to all authenticated users
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Category routes - with permission middleware
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('permission:view categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('permission:create categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('permission:create categories');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show')->middleware('permission:view categories');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:edit categories');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('permission:edit categories');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:delete categories');
    Route::post('categories/{category}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('categories.toggle-featured')->middleware('permission:edit categories');
    Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulk-action')->middleware('permission:manage categories');

    // Product routes - with permission middleware
    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('permission:view products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:create products');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:create products');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('permission:view products');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:edit products');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('permission:edit products');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:delete products');
    Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured')->middleware('permission:edit products');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action')->middleware('permission:manage products');
    Route::post('products/upload-image', [ProductController::class, 'uploadImage'])->name('products.upload-image')->middleware('permission:create products|edit products');
    Route::delete('products/delete-image', [ProductController::class, 'deleteImage'])->name('products.delete-image')->middleware('permission:edit products');

    // Order routes - with permission middleware
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('permission:view orders');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create')->middleware('permission:create orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('permission:create orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('permission:view orders');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware('permission:edit orders');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update')->middleware('permission:edit orders');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('permission:delete orders');
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status')->middleware('permission:edit orders');
    Route::post('orders/{order}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status')->middleware('permission:edit orders');
    Route::post('orders/bulk-action', [OrderController::class, 'bulkAction'])->name('orders.bulk-action')->middleware('permission:manage orders');

    // User management routes - with permission middleware
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:view users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:create users');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:view users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit users');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:edit users');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete users');

    // Role management routes - with permission middleware
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:manage users');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:manage users');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:manage users');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:manage users');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:manage users');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:manage users');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:manage users');

    // Permission management routes - with permission middleware
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:manage users');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:manage users');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:manage users');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('permission:manage users');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:manage users');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:manage users');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:manage users');
});
