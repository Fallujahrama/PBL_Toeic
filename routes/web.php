<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;

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

Route::pattern('id', '[0-9]+');

// login
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'postlogin']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    // dashboard
    Route::get('/', [WelcomeController::class, 'index']);
    Route::get('/profile', [UserController::class, 'profilePage']);
    Route::post('/user/editPhoto', [UserController::class, 'editPhoto']);

    Route::resource('notifications', NotifikasiController::class);
});
