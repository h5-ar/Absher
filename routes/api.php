<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TripController;

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
