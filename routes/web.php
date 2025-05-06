<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Controller;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'postlogin']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('dashboard');
});


