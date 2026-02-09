<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// authentication
use App\Http\Controllers\Api\Authentication\RegisterController;
use App\Http\Controllers\Api\Authentication\LoginController;
use App\Http\Controllers\Api\Authentication\LogoutController;
use App\Http\Controllers\Api\Authentication\EditProfileController;

// user route
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\Cart\AddToCartController;
use App\Http\Controllers\Api\User\Cart\CheckCartController;
use App\Http\Controllers\Api\User\Cart\UpdateCartController;
use App\Http\Controllers\Api\User\Cart\RemoveItemController;
use App\Http\Controllers\Api\User\Checkout\CheckoutController;
use App\Http\Controllers\Api\User\UserController;

// admin
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\AdminProductController;
use App\Http\Controllers\Api\Admin\Order\OrderListController;
use App\Http\Controllers\Api\Admin\Order\UpdateOrderController;




// Public Routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// product routes for public
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/category', [AdminCategoryController::class, 'index']);
Route::get('/category/{id}', [AdminCategoryController::class, 'show']);

// Route::get('/hello', function () {
//     return response()->json([
//         'message' => 'Hello from Laravel API 👋'
//     ]);
// });






// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::put('/edit-profile', [EditProfileController::class, 'editProfile']);

    // Cart route for customer
    Route::get('/cart', [CheckCartController::class, 'index']);
    Route::post('/cart/add/{id}', [AddToCartController::class, 'add']);
    Route::put('/cart/update/{id}', [UpdateCartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [RemoveItemController::class, 'remove']);

    // order route for customer
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    // user 
    Route::get('/user', [UserController::class, 'index']);

    // test route for image access privae
    Route::get('/products/image/{filename}', function ($filename) {
        $path = storage_path("app/private/products/{$filename}");
        dd($path);

        if (!file_exists($path)) abort(404);
        return response()->file($path);
    });
});


// Admin Routes
Route::middleware(['auth:sanctum', 'Admin'])->group(function () {
    // admin category
    Route::apiResource('/admin/category', AdminCategoryController::class);

    // admin product
    Route::apiResource('/admin/product', AdminProductController::class);

    // admin order 
    Route::get('/admin/order', [OrderListController::class, 'index']);
    Route::put('/admin/order/{id}', [UpdateOrderController::class, 'update']);

    // admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
