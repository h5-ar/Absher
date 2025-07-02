<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\CompanysController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\Api\ShippingsController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\CompanySubscriptionController;

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
Route::post('/login',[App\Http\Controllers\Api\AuthController::class,'login']);
Route::post('/check-otp',[AuthController::class,'checkCode']);
Route::post('/getTripByData',[TripController::class,'/getTripByData']);
Route::post('/getTripByCompany',[TripController::class,'/getTripByCompany']);
Route::post('/getTripByCompanyAndDate',[TripController::class,'/getTripByCompanyAndDate']);
Route::prefix('subscriptions')->group(function () {

    Route::prefix('company/{companyId}')->group(function () {

        Route::get('/active', [App\Http\Controllers\Api\CompanySubscriptionController::class, 'getActiveSubscription']);

        Route::put('/{subscriptionId}/update-trips', [CompanySubscriptionController::class, 'updateRemainingTrips']);

        Route::get('/{subscriptionId}', [CompanySubscriptionController::class, 'getSubscriptionDetails']);

        Route::get('/', [CompanySubscriptionController::class, 'getCompanySubscriptions']);
    });



        Route::get('/usersub/{userId}', [CompanySubscriptionController::class, 'userSubscriptions']);



    Route::post('/storesub', [CompanySubscriptionController::class, 'store']);


    Route::post('/renew/{subscriptionId}/{userId}', [CompanySubscriptionController::class, 'renew']);


    Route::delete('/{subscriptionId}/{userId}/cancel', [CompanySubscriptionController::class, 'cancel']);

});

//Route::post('/Apreservations/{id}', [App\Http\Controllers\Api\ReservationController::class, 'sttore']);//euik
   // Route::put('/reservation/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{userId}/{reservationId}', [App\Http\Controllers\Api\ReservationController::class, 'destroy']);
 Route::get('/myreservations/{userId}', [App\Http\Controllers\Api\ReservationController::class, 'esraa_Reservations']);
    Route::post('/esstore/{userId}', [App\Http\Controllers\Api\ReservationController::class, 'hastore']);
    Route::put('/updatee/{reservationId}/{userId}', [App\Http\Controllers\Api\ReservationController::class, 'updatee']);


     Route::get('trips',[TripController::class,'index']);
     Route::get('/trips/{trip_id}', [TripController::class, 'gettrips']);
    Route::get('/trips', [TripController::class, 'index']);
    Route::get('/trips/{trip}/available-seats', [TripController::class, 'availableSeats']);



//});

Route::middleware('auth:sanctum')->get('/companies', [CompanysController::class, 'getCompaniesApi']);

Route::middleware('auth:sanctum')->get('/companies/{id}', [CompanysController::class, 'show']);
Route::middleware('auth:sanctum')->get('/getcompany/{id}', [CompanysController::class, 'hagetCompanyById']);

Route::middleware('auth:sanctum')->get('shippings/user/{id}', [ShippingsController::class, 'index']);


Route::middleware('auth:sanctum')->get('ship/{shipid}/{userId}', [App\Http\Controllers\Api\ShippingsController::class, 'show']);       // تفاصيل شحنة وحدة

//Route::middleware('auth:sanctum')->post('/shippings/{userId}', [ShippingsController::class, 'store']);
Route::post('/shippings/{userId}', [ShippingsController::class, 'store']);

Route::middleware('auth:sanctum')->put('/shippings/{id}', [ShippingsController::class, 'update']);

Route::middleware('auth:sanctum')->delete('/shippings/{id}/{userId}', [ShippingsController::class, 'destroy']);
