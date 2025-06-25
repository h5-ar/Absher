<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/shippings', [ShippingController::class, 'index']);
});
//Route::get('/shippings', [ShippingController::class, 'index']); للجيسون

Route::get('/shippings/{id}', [ShippingController::class, 'show']);

Route::post('/shippings', [ShippingController::class, 'store']);

Route::put('/shippings/{id}', [ShippingController::class, 'update']);

Route::delete('/shippings/{id}', [ShippingController::class, 'destroy']);