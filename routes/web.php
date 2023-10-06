<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginController;
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
    Route::inertia('/', 'Dashboard');
    Route::resource('/clients', ClientController::class);
    Route::post('/logout', [LoginController::class, 'destroy']);
    Route::post('/change-password', [LoginController::class, 'changePassword']);
});
