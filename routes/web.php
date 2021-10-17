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

Auth::routes(['register' => false]);

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/plazas', [App\Http\Controllers\PlazaController::class, 'index'])->name('plazas');
Route::get('/plaza/{plaza}', [App\Http\Controllers\PlazaController::class, 'show'])->name('plaza');
Route::post('/plaza/update', [App\Http\Controllers\PlazaController::class, 'update'])->name('plaza.edit');

Route::get('/newplaza', [App\Http\Controllers\PlazaController::class, 'create'])->name('plaza.create');
Route::post('/plaza/add', [App\Http\Controllers\PlazaController::class, 'store'])->name('plaza.store');

Route::get('/shops', [App\Http\Controllers\ShopController::class, 'index'])->name('shops');
Route::get('/new', [App\Http\Controllers\ShopController::class, 'create'])->name('shops.create');
Route::post('/shops/add', [App\Http\Controllers\ShopController::class, 'store'])->name('shops.store');
Route::get('/shops/expired', [App\Http\Controllers\ShopController::class, 'expired'])->name('shops.expired');
Route::get('/shops/almostdue', [App\Http\Controllers\ShopController::class, 'almostDue'])->name('shops.almost');
Route::get('/shop/{shop}', [App\Http\Controllers\ShopController::class, 'show'])->name('shops.show');
Route::post('/shop/{shop}/delete', [App\Http\Controllers\ShopController::class, 'delete'])->name('shop.delete');

Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments');
Route::post('/payment/mark', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
Route::post('/balance/pay', [App\Http\Controllers\PaymentController::class, 'payBalance'])->name('balance.pay');
Route::post('/payment/{payment}/delete', [App\Http\Controllers\PaymentController::class, 'delete'])->name('payment.delete');


Route::get('/shops/balance_due', [App\Http\Controllers\ShopController::class, 'balance'])->name('balance');

//Toggle vacancy
Route::post('/vacant', [App\Http\Controllers\ShopController::class, 'markAsVacant'])->name('vacant');
Route::post('/occupied', [App\Http\Controllers\ShopController::class, 'markAsOccupied'])->name('occupied');
