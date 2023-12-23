<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkLogController;
use Illuminate\Support\Facades\Route;

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
Route::inertia('/login', 'Login')->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('/clients', ClientController::class);
    Route::resource('/projects', ProjectController::class);
    Route::resource('/volunteers', DeveloperController::class);
    Route::resource('/work-logs', WorkLogController::class);
    Route::get('/work-logs/{year}/{month}', [DashboardController::class, 'index'])->where(['year' => '\d{4}', 'month' => '(?:January|February|March|April|May|June|July|August|September|October|November|December)']);
    Route::post('/logout', [LoginController::class, 'destroy']);
    Route::post('/change-password', [LoginController::class, 'changePassword']);
});
