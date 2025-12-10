<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [App\Http\Controllers\Api\Authentication\RegisterController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\Authentication\LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Api\Authentication\LogoutController::class, 'logout']);
});
