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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])
    ->name('orders.index')
    ->middleware('auth');

Route::get('/orders/create', [App\Http\Controllers\OrderController::class, 'create'])
    ->name('orders.create')
    ->middleware('auth');

Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'addProduct'])
    ->name('orders.product')
    ->middleware('auth');

Route::put('/orders/edit', [App\Http\Controllers\OrderController::class, 'edit'])
    ->name('orders.edit')
    ->middleware('auth');

Route::get('/orders/{order}/label', [App\Http\Controllers\OrderController::class, 'label'])
    ->name('orders.label')
    ->middleware('auth');

Route::get('/pdf/{order}', [App\Http\Controllers\OrderController::class, 'pdf'])
    ->name('orders.pdf')
    ->middleware('auth');

require __DIR__ . '/auth.php';
