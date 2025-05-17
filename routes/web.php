<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\SuratPernyataanController;

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

    Route::middleware(['authorize:AdmUpa'])->group(function () {
        Route::resource('notifications', NotifikasiController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('hasil_ujian', HasilUjianController::class);

        Route::get('surat_pernyataan', [SuratPernyataanController::class, 'index'])->name('surat_pernyataan.index');
        Route::post('surat_pernyataan/{id}/validate', [SuratPernyataanController::class, 'validateSurat'])->name('surat_pernyataan.validate');
        Route::post('surat_pernyataan/{id}/reject', [SuratPernyataanController::class, 'rejectSurat'])->name('surat_pernyataan.reject');
    });

    Route::middleware(['authorize:Mhs'])->group(function () {
        Route::get('surat_pernyataan/upload', [SuratPernyataanController::class, 'createMahasiswa'])->name('surat_pernyataan.createMahasiswa');
        Route::post('surat_pernyataan/store', [SuratPernyataanController::class, 'storeMahasiswa'])->name('surat_pernyataan.storeMahasiswa');
    });

});
