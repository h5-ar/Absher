<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\CompanySubscriptionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/check-otp',[AuthController::class,'checkCode']);
Route::post('/getTripByData',[TripController::class,'/getTripByData']);
Route::post('/getTripByCompany',[TripController::class,'/getTripByCompany']);
Route::post('/getTripByCompanyAndDate',[TripController::class,'/getTripByCompanyAndDate']);
Route::prefix('subscriptions')->group(function () {

    Route::prefix('company/{companyId}')->group(function () {

        Route::get('/active', [CompanySubscriptionController::class, 'getActiveSubscription']);

        Route::put('/{subscriptionId}/update-trips', [CompanySubscriptionController::class, 'updateRemainingTrips']);

        Route::get('/{subscriptionId}', [CompanySubscriptionController::class, 'getSubscriptionDetails']);

        Route::get('/', [CompanySubscriptionController::class, 'getCompanySubscriptions']);
    });


    Route::prefix('user/{userId}')->group(function () {
        Route::get('/', [CompanySubscriptionController::class, 'getUserSubscriptions']);
    });


    Route::post('/', [CompanySubscriptionController::class, 'store']);


    Route::put('/{subscriptionId}/renew', [CompanySubscriptionController::class, 'renew']);


    Route::put('/{subscriptionId}/cancel', [CompanySubscriptionController::class, 'cancel']);

});

Route::middleware(['auth:sanctum'])->group(function (){
     Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
      Route::put('reservation/{passengerId}', [ReservationController::class, 'Edit']);
        Route::get('/reservations', [ReservationController::class, 'index']);
     Route::post('/store-reservations', [ReservationController::class, 'store']);

     Route::get('trips',[TripController::class,'index']);
      Route::get('/trips/search', [TripController::class, 'show']);



});
