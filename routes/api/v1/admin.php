<?php

use App\Http\Controllers\Admin\V1\AuthController;
use App\Http\Controllers\Admin\V1\BusinessHourController;
use App\Http\Controllers\Admin\V1\CategoryController;
use App\Http\Controllers\Admin\V1\OrderController;
use App\Http\Controllers\Admin\V1\ProductController;
use App\Http\Controllers\Admin\V1\PromotionController;
use App\Http\Controllers\Admin\V1\SettingController;
use App\Http\Controllers\Admin\V1\ShippingMethodController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    //Categories
    Route::resource('categories', CategoryController::class)->only(['index']);

    //Products
    Route::resource('products', ProductController::class);

    //Promotions
    Route::resource('promotions', PromotionController::class)->only(['index', 'update']);

    //Shipping Method
    Route::resource('shipping-methods', ShippingMethodController::class)->only(['index']);

    //Order
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    //Settings
    Route::prefix('settings')->group(function () {
        Route::get('business-hours', [BusinessHourController::class, 'index']);
        Route::post('business-hours', [BusinessHourController::class, 'store']);
        Route::get('postal-codes', [SettingController::class, 'getPostalCode']);
        Route::post('postal-codes', [SettingController::class, 'savePostalCode']);
    });
});

