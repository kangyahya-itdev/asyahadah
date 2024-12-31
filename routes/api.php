<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProductController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('check-referral-code', [AuthController::class, 'checkReferralCode']);
Route::post('login', [AuthController::class, 'login']);
Route::get('products', [ProductController::class, 'index']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'getProfile']); // Using controller instead of anonymous function
    Route::post('user/profile-image', [UserController::class, 'setImageProfile']);
    Route::post('orders', [OrderController::class, 'create']);
    Route::get('wallet', [WalletController::class, 'getBalance']);
    Route::post('logout', [AuthController::class, 'logout']);
});
