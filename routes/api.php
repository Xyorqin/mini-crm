<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/buy_product', [App\Http\Controllers\BuyController::class, 'buyProducts']);
Route::post('/refund_buy_product/{id}', [App\Http\Controllers\BuyController::class, 'refundBuyProducts']);
Route::get('/products_list', [App\Http\Controllers\ProductController::class, 'index']);
Route::post('/sell_product', [App\Http\Controllers\OrderController::class, 'sellProduct']);


Route::post('/refund_sell_product/{id}', [App\Http\Controllers\OrderController::class, 'refundSellProduct']);
