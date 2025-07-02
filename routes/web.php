<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\ShippingController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\SATripController;
use App\Http\Controllers\SABusController;
use App\Http\Controllers\SAPlanController;
use App\Http\Controllers\SubscriptionController;
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

Route::post('change-lang', [SuperAdminController::class, 'switchLang'])->name('dashboard.set.lang');

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::middleware('auth:super_admin')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard/superadmin', [SuperAdminController::class, 'index'])->name('super_admin.dashboard');
    Route::get('company/index', [CompanyController::class, 'index'])->name('company.index');
    Route::get('company/add', [CompanyController::class, 'create'])->name('add.company');
    Route::post('company/store', [CompanyController::class, 'store'])->name('store.company');
    Route::get('company/edit/{id}', [CompanyController::class, 'edit'])->name('edit.company');
    Route::put('company/update/{id}', [CompanyController::class, 'update'])->name('update.company');
    Route::delete('company/delete/{id}', [CompanyController::class, 'destroy'])->name('delete.company');

    Route::get('manager/index', [ManagerController::class, 'index'])->name('manager.index');
    Route::get('manager/add', [ManagerController::class, 'create'])->name('add.manager');
    Route::post('manager/store', [ManagerController::class, 'store'])->name('store.manager');
    Route::get('manager/edit/{id}', [ManagerController::class, 'edit'])->name('edit.manager');
    Route::put('manager/update/{id}', [ManagerController::class, 'update'])->name('update.manager');
    Route::delete('manager/delete/{id}', [ManagerController::class, 'destroy'])->name('delete.manager');

    Route::get('user/index', [UserController::class, 'index'])->name('index.user');
    Route::get('user/add', [UserController::class, 'create'])->name('add.user');
    Route::post('user/store', [UserController::class, 'store'])->name('store.user');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('update.user');
    Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('delete.user');

    Route::get('index', [SATripController::class, 'index'])->name('index');
    Route::get('addQ', [SATripController::class, 'createQuick'])->name('add.q');
    Route::get('addV', [SATripController::class, 'createVehicle'])->name('add.v');
    Route::post('storeQuick', [SATripController::class, 'storeQuick'])->name('storeQuick');
    Route::post('storeVehicle', [SATripController::class, 'storeVehicle'])->name('storeVehicle');
    Route::post('store', [SATripController::class, 'store'])->name('store');
    Route::get('edit/{id}', [SATripController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [SATripController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [SATripController::class, 'destroy'])->name('delete');

    Route::get('SuperAdmin/add/bus', [SABusController::class, 'create'])->name('SAadd.bus');
    Route::post('SuperAdmin/store', [SABusController::class, 'store'])->name('SAbus.store');
    Route::get('SuperAdmin/bus/index', [SABusController::class, 'index'])->name('SAbus.index');
    Route::get('SuperAdmin/bus/show', [SABusController::class, 'show'])->name('SAbus.show');
    Route::get('SuperAdmin/bus/edit/{id}', [SABusController::class, 'edit'])->name('SAbus.edit');
    Route::put('SuperAdmin/bus/update/{id}', [SABusController::class, 'update'])->name('SAbus.update');
    Route::delete('SuperAdmin/bus/delete/{id}', [SABusController::class, 'destroy'])->name('SAbus.delete');

    Route::get('SuperAdmin/plan/add', [SAPlanController::class, 'create'])->name('SAadd.plan');
    Route::get('SuperAdmin/plan/index', [SAPlanController::class, 'index'])->name('SAindex.plan');
    Route::post('SuperAdmin/plan/store', [SAPlanController::class, 'store'])->name('SAstore.plan');
    Route::get('SuperAdmin/plan/edit/{id}', [SAPlanController::class, 'edit'])->name('SAplan.edit');
    Route::put('SuperAdmin/plan/update/{id}', [SAPlanController::class, 'update'])->name('SAplan.update');
    Route::delete('SuperAdmin/plan/delete/{id}', [SAPlanController::class, 'destroy'])->name('SAplan.delete');
});


Route::middleware('auth:company')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard/admin', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/profile/show', [DashboardController::class, 'profile'])->name('dashboard.profile.show');
    Route::get('dashboard/profile/edit/{id}', [DashboardController::class, 'editprofile'])->name('dashboard.profile.edit');
    Route::put('dashboard/profile/update/{id}', [DashboardController::class, 'updateprofile'])->name('dashboard.profile.update');

    Route::get('add/quick', [TripController::class, 'createQuick'])->name('add.quick');
    Route::get('add/vehicle', [TripController::class, 'createVehicle'])->name('add.vehicle');
    Route::get('trip/index', [TripController::class, 'index'])->name('trip.index');
    Route::get('trip/edit/{id}', [TripController::class, 'edit'])->name('trip.edit');
    Route::put('trip/update/{id}', [TripController::class, 'update'])->name('trip.update');
    Route::delete('trip/delete/{id}', [TripController::class, 'destroy'])->name('trip.delete');
    Route::post('trip/storeQuick', [TripController::class, 'storeQuick'])->name('trip.storeQuick');
    Route::post('trip/storeVehicle', [TripController::class, 'storeVehicle'])->name('trip.storeVehicle');
    Route::get('/trips/filter', [TripController::class, 'filter'])->name('trips.filter');

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

    Route::get('reservation/index', [ReservationController::class, 'index'])->name('index.reservation');
    Route::get('/reservation/passengers', [ReservationController::class, 'passengers'])->name('reservation.passengers');
    Route::get('reservation/edit/{id}', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('reservation/update/{id}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::delete('reservation/delete/{id}', [ReservationController::class, 'destroy'])->name('reservation.delete');
    Route::get('reservation/add', [ReservationController::class, 'create'])->name('add.reservation');
    Route::post('reservation/store', [ReservationController::class, 'storeAdmin'])->name('storeAdmin.reservation');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('passenger/index', [PassengerController::class, 'index'])->name('index.passenger');
    Route::get('passenger/edit/{id}', [PassengerController::class, 'edit'])->name('passenger.edit');
    Route::put('passenger/update/{id}', [PassengerController::class, 'update'])->name('passenger.update');

    Route::delete('passenger/delete/{id}/{reservation_id}', [PassengerController::class, 'destroy'])
        ->name('passenger.delete');
    Route::get('/user/details', [UserController::class, 'getUserDetails'])->name('user.details');
    Route::get('/trip/details', [TripController::class, 'getTripDetails'])->name('trip.details');
    Route::get('/plan/details', [PlanController::class, 'getPlanDetails'])->name('plan.details');
    Route::get('/plans/getAllPlan', [PlanController::class, 'getAllPlan'])->name('all.plans');

    Route::get('subscribtion/index', [SubscriptionController::class, 'index'])->name('index.subscription');
    Route::delete('shisubscriptionpping/delete/{id}', [SubscriptionController::class, 'destroy'])->name('subscription.delete');

    Route::get('shipping/add', [ShippingController::class, 'create'])->name('add.shipping');
    Route::get('shipping/index', [ShippingController::class, 'index'])->name('index.shipping');
    Route::post('shipping/store', [ShippingController::class, 'store'])->name('store.shipping');
    Route::get('shipping/edit/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
    Route::put('shipping/update/{id}', [ShippingController::class, 'update'])->name('shipping.update');
    Route::delete('shipping/delete/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');
});
Route::post('set-theme', function () {
    Session::put('theme', request()->get('theme'));
    return true;
})->name('set.theme');
