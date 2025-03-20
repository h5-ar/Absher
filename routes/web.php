<?php

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;

use App\Http\Controllers\SuperAdminController;


use App\Http\Controllers\TripController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;

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


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::middleware('auth:super_admin')->group(function () {
    Route::get('dashboard/superadmin', [SuperAdminController::class, 'index'])->name('super_admin.dashboard');

});


Route::middleware('auth:company')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard/admin', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/profile/show', [DashboardController::class, 'profile'])->name('dashboard.profile.show');
    Route::get('settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('change-lang', [DashboardController::class, 'switchLang'])->name('dashboard.set.lang');
    Route::get('add/quick', [TripController::class, 'createQuick'])->name('add.quick');
    Route::get('add/vehicle', [TripController::class, 'createVehicle'])->name('add.vehicle');
    Route::get('trip/index', [TripController::class, 'index'])->name('trip.index');
    Route::get('trip/edit/{id}', [TripController::class, 'edit'])->name('trip.edit');
    Route::put('trip/update/{id}', [TripController::class, 'update'])->name('trip.update');
    Route::delete('trip/delete/{id}', [TripController::class, 'destroy'])->name('trip.delete');
    Route::post('trip/storeQuick', [TripController::class, 'storeQuick'])->name('trip.storeQuick');
    Route::post('trip/storeVehicle', [TripController::class, 'storeVehicle'])->name('trip.storeVehicle');
    Route::get('add/bus', [BusController::class, 'create'])->name('add.bus');
    Route::post('store', [BusController::class, 'store'])->name('bus.store');
    Route::get('bus/index', [BusController::class, 'index'])->name('bus.index');
    Route::get('bus/show', [BusController::class, 'show'])->name('bus.show');
    Route::get('bus/edit/{id}', [BusController::class, 'edit'])->name('bus.edit');
    Route::put('bus/update/{id}', [BusController::class, 'update'])->name('bus.update');
    Route::delete('bus/delete/{id}', [BusController::class, 'destroy'])->name('bus.delete');
    Route::get('check', [BusController::class, 'getLoggedInCompanyId']);
    Route::get('plan/add', [PlanController::class, 'create'])->name('add.plan');
    Route::get('plan/index', [PlanController::class, 'index'])->name('index.plan');
    Route::post('plan/store', [PlanController::class, 'store'])->name('store.plan');
    Route::get('plan/edit/{id}', [PlanController::class, 'edit'])->name('plan.edit');
    Route::put('plan/update/{id}', [PlanController::class, 'update'])->name('plan.update');
    Route::delete('plan/delete/{id}', [PlanController::class, 'destroy'])->name('plan.delete');
});
//Route::get('/reservation',[ReservationController::class,'index']);
Route::post('set-theme', function () {
    Session::put('theme', request()->get('theme'));
    return true;
})->name('set.theme');
