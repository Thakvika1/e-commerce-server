<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Authentication\RegisterController;
use App\Http\Controllers\Api\Authentication\LoginController;
use App\Http\Controllers\Api\Authentication\LogoutController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\AdminOrderController;
use App\Http\Controllers\Api\Admin\AdminProductController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\OrderController;
// use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\Cart\AddToCartController;
use App\Http\Controllers\Api\User\Cart\CheckCartController;
use App\Http\Controllers\Api\User\Cart\UpdateCartController;
use App\Http\Controllers\Api\User\Cart\RemoveItemController;






// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Public Routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// product routes for public
Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);


// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);

    // Cart route for customer
    Route::get('/cart', [CheckCartController::class, 'index']);
    Route::post('/cart/add/{id}', [AddToCartController::class, 'add']);
    Route::put('/cart/update/{id}', [UpdateCartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [RemoveItemController::class, 'remove']);

    // order route for customer
    Route::post('/checkout', [OrderController::class, 'checkout']);
});


// Admin Routes
Route::middleware(['auth:sanctum', 'Admin'])->group(function () {
    // admin category
    Route::apiResource('/admin/category', AdminCategoryController::class);

    // admin product
    Route::apiResource('/admin/product', AdminProductController::class);

    // admin order 
    Route::get('/admin/order', [AdminOrderController::class, 'index']);
    Route::put('/admin/order/{id}', [AdminOrderController::class, 'update']);

    // admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
