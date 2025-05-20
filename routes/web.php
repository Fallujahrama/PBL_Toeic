<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\VerifikasiController;

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
    Route::get('jadwal/preview/{id}', [JadwalController::class, 'previewFile'])->name('jadwal.preview');
    Route::get('jadwal/{id}/data', [JadwalController::class, 'getJadwal'])->name('jadwal.data');

    // Hasil Ujian routes
    Route::resource('hasil_ujian', HasilUjianController::class);

    // Mahasiswa routes
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

    // Verification routes
    Route::group(['prefix' => 'verifikasi'], function () {
        Route::get('/', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::get('/create', [VerifikasiController::class, 'create'])->name('verifikasi.create');
        Route::post('/', [VerifikasiController::class, 'store'])->name('verifikasi.store');
        Route::get('/{id}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
        Route::get('/{id}/edit', [VerifikasiController::class, 'edit'])->name('verifikasi.edit');
        Route::put('/{id}', [VerifikasiController::class, 'update'])->name('verifikasi.update');
        Route::delete('/{id}', [VerifikasiController::class, 'destroy'])->name('verifikasi.destroy');
        Route::post('/{id}/verify', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
        Route::get('/{id}/download/{type}', [VerifikasiController::class, 'downloadFile'])->name('verifikasi.download');
    });
});
