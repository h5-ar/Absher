<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TripController;

use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('Auth.login');
});
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('change-lang', [DashboardController::class, 'switchLang'])->name('dashboard.set.lang');
Route::get('add', [TripController::class, 'create'])->name('add');
Route::get('index', [TripController::class, 'index'])->name('index');
Route::post('store', [TripController::class, 'store'])->name('trip.store');



Route::post('set-theme', function () {
    Session::put('theme', request()->get('theme'));
    return true;
})->name('set.theme');
