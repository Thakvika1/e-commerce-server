<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Authentication\RegisterController;
use App\Http\Controllers\Api\Authentication\LoginController;
use App\Http\Controllers\Api\Authentication\LogoutController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\AdminProductController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\CartController;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Public Routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);


// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);

    // product routes for customers
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/product/{id}', [ProductController::class, 'show']);

    // Cart route for customer
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{id}', [CartController::class, 'add']);
    Route::post('/cart/update/{id}', [CartController::class, 'update']);
    Route::post('/cart/remove/{id}', [CartController::class, 'remove']);

    // order route for customer
    Route::post('/checkout', [OrderController::class, 'checkOut']);
});


// Admin Routes
Route::middleware(['auth:sanctum', 'Admin'])->group(function () {
    Route::apiResource('/admin/category', AdminCategoryController::class);
    Route::apiResource('/admin/product', AdminProductController::class);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
