<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MahasiswaController;
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

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::get('/', [PendaftaranController::class, 'index'])->name('index');
    Route::get('/baru', [PendaftaranController::class, 'formBaru'])->name('baru');
    Route::post('/baru', [PendaftaranController::class, 'storeBaru'])->name('storeBaru');
    Route::get('/pendaftaran/lama/get-mahasiswa/{nim}', [PendaftaranController::class, 'getMahasiswa']);
    Route::get('/lama', [PendaftaranController::class, 'formLama'])->name('lama');
    Route::post('/lama', [PendaftaranController::class, 'storeLama'])->name('lama.store');
});

// Route::get('/hasil-ujian', [HasilUjianController::class, 'index'])->name('hasil.ujian');// web.php (Route)


Route::prefix('hasil-ujian')->name('hasil_ujian.')->group(function () {
    Route::get('/', [HasilUjianController::class, 'index'])->name('hasil.ujian');
    Route::get('/result', [HasilUjianController::class, 'showResult'])->name('show_result');
    Route::get('/download', [HasilUjianController::class, 'download'])->name('download');
});


Route::get('/data_mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');







