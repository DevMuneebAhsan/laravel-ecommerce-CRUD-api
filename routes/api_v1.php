<?php

use App\Http\Controllers\Api\V1\CategoryController;
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
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class)->except('update');
    Route::put('products/{product}', [ProductController::class, 'replace']);
    Route::patch('products/{product}', [ProductController::class, 'update']);

    Route::apiResource('categories', CategoryController::class)->except('update');
    Route::put('categories/{category}', [CategoryController::class, 'replace']);
    Route::patch('categories/{category}', [CategoryController::class, 'update']);

    Route::apiResource('users', UsersController::class);

    Route::apiResource('users.products', UserProductsController::class)->except('update');
    Route::put('users/{user}/products/{product}', [UserProductsController::class, 'replace']);
    Route::patch('users/{user}/products/{product}', [UserProductsController::class, 'update']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
