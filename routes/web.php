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
    Route::resource('pendaftaran', PendaftaranController::class);
    Route::get('/pendaftaran/{id}/preview-pdf/{type}', [PendaftaranController::class, 'previewPdf'])->name('pendaftaran.preview-pdf');
    Route::get('/pendaftaran/{id}/stream-pdf/{type}', [PendaftaranController::class, 'streamPdf'])->name('pendaftaran.stream-pdf');
    Route::get('/pendaftaran/export', [PendaftaranController::class, 'export'])->name('pendaftaran.export');
    Route::post('/pendaftaran/import', [PendaftaranController::class, 'import'])->name('pendaftaran.import');
    Route::post('/pendaftaran/approve/{id}', [PendaftaranController::class, 'approve'])->name('pendaftaran.approve');
    Route::post('/pendaftaran/reject/{id}', [PendaftaranController::class, 'reject'])->name('pendaftaran.reject');

    // Jadwal routes
    Route::resource('jadwal', JadwalController::class);
    // Route::get('jadwal/download/{id}', [JadwalController::class, 'downloadFile'])->name('jadwal.download'); // Removed download route
    Route::get('jadwal/preview/{id}', [JadwalController::class, 'previewFile'])->name('jadwal.preview');
    Route::get('jadwal/{id}/data', [JadwalController::class, 'getJadwal'])->name('jadwal.data');
});