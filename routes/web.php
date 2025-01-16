<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WalletController;

use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [FrontController::class, 'login'])->name('login');
Route::get('/register', [FrontController::class, 'register'])->name('register');


Route::post('/login', [UserController::class, 'setLogin']);
Route::post('/register', [UserController::class, 'register'])->name('register.store');

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum')->name('logout');


Route::get('/front', [FrontController::class, 'index']);


// User Area
Route::get('/user_area',[HomeController::class, 'index'])->middleware('auth:sanctum')->name('user_area');
Route::get('/user_area/product', [ProductController::class, 'index'])->middleware('auth:sanctum')->name('user_area.product');
Route::get('/user_area/product/hsitory',[ProductController::class, 'history'])->middleware('auth:sanctum')->name('user_area.product.history');



//Profile
Route::get('/user_area/profile', [UserController::class, 'index'])->middleware('auth:sanctum')->name('user_area.profile');
Route::get('/user_area/profile/edit', [UserController::class, 'edit_profile'])->middleware('auth:sanctum')->name('user_area.profile.edit_profile');
Route::post('/user_area/order', [OrderController::class, 'create'])->middleware('auth:sanctum')->name('user_area.set.order');
Route::post('/user_area/order/pay/{id}',[OrderController::class,'pay'])->middleware('auth:sanctum')->name('user_area.set.pay');
Route::get('/user_area/topup', [WalletController::class, 'index'])->middleware('auth:sanctum')->name('user_area.topup');
Route::post('/user_area/topup', [WalletController::class, 'uploadProof'])->middleware('auth:sanctum')->name('user_area.proof');

Route::get('/user_area/profile/add_rekening', [WalletController::class, 'add_rekening'])->middleware('auth:sanctum')->name('user_area.profile.add_rekening');

Route::post('/user_area/profile/add_rekening', [WalletController::class, 'store_rekening'])->middleware('auth:sanctum')->name('user_area.profile.store_rekening');

Route::get('/user_area/profile/edit_rekening', [WalletController::class, 'edit_rekening'])->middleware('auth:sanctum')->name('user_area.profile.edit_rekening');

Route::put('/user_area/profile/edit_rekening/{id}', [WalletController::class, 'update_rekening'])->middleware('auth:sanctum')->name('user_area.profile.update_rekening');



// For Admin

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('admin')
    ->name('admin.dashboard');

    //Product for admin
Route::get('/admin/product', [ProductController::class, 'list'])
    ->middleware('admin')
    ->name('admin.product');
Route::get('/admin/product/add/{id?}', [ProductController::class, 'add'])
    ->middleware('admin')
    ->name('admin.product.add');
Route::post('/admin/product/store', [ProductController::class, 'store'])
    ->middleware('admin')
    ->name('admin.product.store');
Route::delete('/admin/product/delete/{id?}', [ProductController::class, 'delete_product'])
    ->middleware('admin')
    ->name('admin.product.delete');

// Commission Product for admin   
Route::get('/admin/commissions', [ProductController::class, 'commission_product'])
    ->middleware('admin')
    ->name('admin.commissions');
Route::get('/admin/commissions/insert/{id?}', [ProductController::class, 'insert_commission_product'])
    ->middleware('admin')
    ->name('admin.commissions.insert');
Route::post('/admin/commissions/store-commission-product', [ProductController::class, 'store_commission_product'])
    ->middleware('admin')
    ->name('admin.commissions.store');
Route::delete('/admin/commissions/destroy/{id?}', [ProductController::class, 'delete_commission_product'])
    ->middleware('admin')
    ->name('admin.commissions.delete');


// Order for admin
Route::get('/admin/orders', [OrderController::class, 'list'])
    ->middleware('admin')
    ->name('admin.orders');
// Top Up for admin
    Route::get('/admin/topups', [WalletController::class, 'list'])
    ->middleware('admin')
    ->name('admin.topups');
    Route::get('/admin/topups/{id}/confirm', [WalletController::class, 'confirm'])
    ->middleware('admin')
    ->name('admin.topups.confirm');
    Route::get('/admin/topups/{id}/reject', [WalletController::class, 'reject'])
    ->middleware('admin')
    ->name('admin.topups.reject');


// User for admin
Route::get('/admin/users', [UserController::class, 'index'])
    ->middleware('admin')
    ->name('admin.users');
