<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CashRegisterController;

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

Route::get('/',                     [DashboardController::class, 'index']);
Route::get('/',                     [DashboardController::class, 'index']);

Route::get('/products',             [ProductsController::class, 'index']);
Route::post('/products',            [ProductsController::class, 'store']);
Route::put('/products/{id}',        [ProductsController::class, 'update']);
Route::post('/products-pagination', [ProductsController::class, 'pagination']);
Route::delete('/products/{id}',     [ProductsController::class, 'destroy']);

Route::get('/cash-register',        [CashRegisterController::class, 'index' ]);
Route::get('/client/{id}',          [CashRegisterController::class, 'clientById']);

