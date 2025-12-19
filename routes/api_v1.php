<?php

use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserProductsController;
use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/products', function (Request $request) {
//     return response()->json([
//         'hello from api v1'
//     ]);
// });
Route::middleware('auth:sanctum')->apiResource('products', ProductController::class);
Route::middleware('auth:sanctum')->apiResource('users', UsersController::class);
Route::middleware('auth:sanctum')->apiResource('users.products', UserProductsController::class);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
