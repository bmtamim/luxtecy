<?php

use App\Http\Controllers\Admin\V1\AuthController;
use App\Http\Controllers\Admin\V1\CategoryController;
use App\Http\Controllers\Admin\V1\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    //Categories
    Route::resource('categories', CategoryController::class)->only(['index']);

    //Products
    Route::resource('products', ProductController::class);
});

