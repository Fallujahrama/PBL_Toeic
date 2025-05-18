<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\JadwalController;

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'postlogin']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profilePage']);
    Route::post('/user/editPhoto', [UserController::class, 'editPhoto']);

    // Notifications routes
    Route::resource('notifications', NotifikasiController::class);

    // Pendaftaran routes
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', [PendaftaranController::class, 'index'])->name('index');
        Route::get('/baru', [PendaftaranController::class, 'formBaru'])->name('baru');
        Route::post('/baru', [PendaftaranController::class, 'storeBaru'])->name('storeBaru');
        Route::get('/lama/get-mahasiswa/{nim}', [PendaftaranController::class, 'getMahasiswa']);
        Route::get('/lama', [PendaftaranController::class, 'formLama'])->name('lama');
        Route::post('/lama', [PendaftaranController::class, 'storeLama'])->name('lama.store');
    });

    // Jadwal routes
    Route::resource('jadwal', JadwalController::class);
    // Route::get('jadwal/download/{id}', [JadwalController::class, 'downloadFile'])->name('jadwal.download'); // Removed download route
    Route::get('jadwal/preview/{id}', [JadwalController::class, 'previewFile'])->name('jadwal.preview');
    Route::get('jadwal/{id}/data', [JadwalController::class, 'getJadwal'])->name('jadwal.data');
});