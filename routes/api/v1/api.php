<?php

use App\Http\Controllers\Api\V1\AppController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//App info
Route::get('app', AppController::class);
//Get user session token
Route::get('user-token', UserTokenController::class);
//Get Categories
Route::get('categories', [CategoryController::class, 'index']);
//Get Products
Route::get('products', [ProductController::class, 'index']);
