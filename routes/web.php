<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::redirect('/', '/login');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/shops', [App\Http\Controllers\ShopController::class, 'index'])->name('shops');
Route::get('/new', [App\Http\Controllers\ShopController::class, 'create'])->name('shops.create');
Route::post('/shops/add', [App\Http\Controllers\ShopController::class, 'store'])->name('shops.store');
Route::get('/shops/expired', [App\Http\Controllers\ShopController::class, 'expired'])->name('shops.expired');
Route::get('/shops/almostdue', [App\Http\Controllers\ShopController::class, 'almostDue'])->name('shops.almost');
Route::get('/shop/{shop}', [App\Http\Controllers\ShopController::class, 'show'])->name('shops.show');
Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments');
Route::post('/payment/mark', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
