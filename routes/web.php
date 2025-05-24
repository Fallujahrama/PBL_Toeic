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

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'postlogin'])->name('postlogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware('auth')->group(function () {
    // Common routes for all authenticated users
    Route::get('/profile', [UserController::class, 'profilePage'])->name('profile');
    
    // Admin routes (AdmUpa and AdmITC)
    Route::middleware(['authorize:AdmUpa,AdmITC'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        // Notifications routes
        Route::resource('notifikasi', NotifikasiController::class);
        
        // Jadwal routes
        Route::resource('jadwal', JadwalController::class);
        Route::get('jadwal/preview/{id}', [JadwalController::class, 'previewFile'])->name('jadwal.preview');
        Route::get('jadwal/{id}/data', [JadwalController::class, 'getJadwal'])->name('jadwal.data');
        
        // Hasil Ujian routes
        Route::resource('hasil_ujian', HasilUjianController::class);
        
        // Mahasiswa routes
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        
        // Verification routes
        Route::resource('verifikasi', VerifikasiController::class);
        Route::post('/verifikasi/{id}/verify', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
        Route::get('/verifikasi/{id}/download/{type}', [VerifikasiController::class, 'downloadFile'])->name('verifikasi.download');
    });
    
    // Student routes (Mhs)
    Route::middleware(['authorize:Mhs'])->group(function () {
        Route::get('/mahasiswa/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('mahasiswa.dashboard');
        
        // Pendaftaran routes
        Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
            Route::get('/', [PendaftaranController::class, 'index'])->name('index');
            Route::get('/baru', [PendaftaranController::class, 'createBaru'])->name('baru');
            Route::post('/baru', [PendaftaranController::class, 'storeBaru'])->name('storeBaru');
            Route::get('/lama', [PendaftaranController::class, 'createLama'])->name('lama');
            Route::post('/lama', [PendaftaranController::class, 'storeLama'])->name('lama.store');
            Route::get('/lama/get-mahasiswa/{nim}', [PendaftaranController::class, 'getMahasiswa'])->name('getMahasiswa');
        });
        
        // Jadwal routes for students
        Route::get('/mahasiswa/jadwal', [JadwalController::class, 'mahasiswaIndex'])->name('mahasiswa.jadwal');
        Route::get('/mahasiswa/jadwal/{id}', [JadwalController::class, 'mahasiswaShow'])->name('mahasiswa.jadwal.show');
        
        // Hasil Ujian routes for students
        Route::get('/mahasiswa/hasil-ujian', [HasilUjianController::class, 'mahasiswaIndex'])->name('mahasiswa.hasil_ujian');
        Route::get('/mahasiswa/hasil-ujian/{id}', [HasilUjianController::class, 'mahasiswaShow'])->name('mahasiswa.hasil_ujian.show');
        
        // Notifications routes for students
        Route::get('/mahasiswa/notifikasi', [NotifikasiController::class, 'mahasiswaIndex'])->name('mahasiswa.notifikasi');
        Route::get('/mahasiswa/notifikasi/{id}', [NotifikasiController::class, 'mahasiswaShow'])->name('mahasiswa.notifikasi.show');
        Route::post('/mahasiswa/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('mahasiswa.notifikasi.read');
    });
});
