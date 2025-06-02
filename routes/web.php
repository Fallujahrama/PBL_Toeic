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
use App\Http\Controllers\SuratPernyataanController;

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'postlogin'])->name('postlogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Landing page route
Route::get('/', function () {
    return view('landing');})->name('landing');
Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware('auth')->group(function () {
    // Common routes for all authenticated users
    Route::get('/profile', [UserController::class, 'profilePage'])->name('profile');
    Route::post('/user/editPhoto', [UserController::class, 'editPhoto'])->name('user.editPhoto');

    // Admin routes (AdmUpa and AdmITC)
    Route::middleware(['authorize:AdmUpa,AdmITC'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Notifications routes
        Route::prefix('admin')->group(function () {
            Route::resource('notifications', NotifikasiController::class);
        });
        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

        // Jadwal routes
        Route::resource('jadwal', JadwalController::class);
        Route::get('jadwal/preview/{id}', [JadwalController::class, 'previewFile'])->name('jadwal.preview');
        Route::get('jadwal/{id}/data', [JadwalController::class, 'getJadwal'])->name('jadwal.data');

        // Hasil Ujian routes
        Route::resource('hasil_ujian', HasilUjianController::class);

        // Verification routes
        Route::resource('verifikasi', VerifikasiController::class);
        Route::post('/verifikasi/{id}/verify', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
        Route::get('/verifikasi/{id}/preview/{jenis}', [VerifikasiController::class, 'preview'])->name('dokumen.preview');
        Route::get('/verifikasi/{id}/download/{type}', [VerifikasiController::class, 'downloadFile'])->name('verifikasi.download');

        // Profile routes
        Route::get('/admin/profile/edit', [UserController::class, 'editAdmin'])->name('admin.profile.edit');
        Route::post('/admin/profile/update', [UserController::class, 'updateAdmin'])->name('admin.profile.update');

        Route::resource('surat-pernyataan', SuratPernyataanController::class);

        // Routes untuk Template Surat - Admin
        Route::prefix('admin')->name('admin.')->group(function () {
            // Surat Pernyataan routes
            Route::get('/surat-pernyataan/download-all', [SuratPernyataanController::class, 'downloadAll'])->name('surat-pernyataan.download-all');
            Route::get('/surat-pernyataan', [SuratPernyataanController::class, 'adminIndex'])->name('surat-pernyataan.index');
            Route::get('/surat-pernyataan/{id}', [SuratPernyataanController::class, 'adminShow'])->name('surat-pernyataan.show');
            Route::patch('/surat-pernyataan/{id}/validate', [SuratPernyataanController::class, 'validateSurat'])->name('surat-pernyataan.validate');
            Route::patch('/surat-pernyataan/{id}/reject', [SuratPernyataanController::class, 'reject'])->name('surat-pernyataan.reject');

            // Template routes
            Route::post('/surat-pernyataan/upload-template', [SuratPernyataanController::class, 'uploadTemplate'])->name('surat-pernyataan.upload-template');
            Route::patch('/surat-pernyataan/template/{id}/toggle-status', [SuratPernyataanController::class, 'toggleStatus'])->name('surat-pernyataan.toggle-status');
        });
    });

    // Admin ITC specific routes (only AdmITC)
    Route::middleware(['authorize:AdmITC'])->group(function () {
        // Data Mahasiswa Management routes - only for AdmITC
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
            Route::get('/mahasiswa/{nim}/show', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
            Route::get('/mahasiswa/{nim}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
            Route::put('/mahasiswa/{nim}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
            Route::delete('/mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
        });
    });

    // Student routes (Mhs)
    Route::middleware(['authorize:Mhs'])->group(function () {
        Route::get('/mahasiswa/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('mahasiswa.dashboard');

        // Pendaftaran routes
        Route::prefix('mahasiswa/pendaftaran')->name('pendaftaran.')->group(function () {
            Route::get('/', [PendaftaranController::class, 'index'])->name('index');
            Route::get('/baru', [PendaftaranController::class, 'createBaru'])->name('baru');
            Route::post('/baru', [PendaftaranController::class, 'storeBaru'])->name('storeBaru');
            Route::get('/lama', [PendaftaranController::class, 'createLama'])->name('lama');
            Route::post('/lama', [PendaftaranController::class, 'storeLama'])->name('lama.store');
            Route::get('/lama/get-mahasiswa/{nim}', [PendaftaranController::class, 'getMahasiswa'])->name('getMahasiswa');
            Route::get('/{id}/show', [PendaftaranController::class, 'showRegistration'])->name('show');

            // File preview route - TAMBAHAN ROUTE INI
            Route::get('/{nim}/preview/{type}', [PendaftaranController::class, 'previewFile'])->name('preview');
        });

        // Student data management routes - untuk mahasiswa edit data sendiri
        Route::prefix('mahasiswa/data')->name('mahasiswa.data.')->group(function () {
            Route::get('/{nim}/edit', [PendaftaranController::class, 'editMahasiswa'])->name('edit');
            Route::put('/{nim}', [PendaftaranController::class, 'updateMahasiswa'])->name('update');
            Route::get('/{nim}/show', [PendaftaranController::class, 'showMahasiswa'])->name('show');
        });

        // Jadwal routes for students
        Route::get('/mahasiswa/jadwal', [JadwalController::class, 'mahasiswaIndex'])->name('mahasiswa.jadwal');
        Route::get('/mahasiswa/jadwal/preview/{id}', [JadwalController::class, 'previewFile'])->name('mahasiswa.jadwal.preview');

        // Hasil Ujian routes for students
        Route::get('/mahasiswa/hasil-ujian', [HasilUjianController::class, 'mahasiswaIndex'])->name('mahasiswa.hasil_ujian');
        Route::get('/mahasiswa/hasil-ujian/{id}', [HasilUjianController::class, 'mahasiswaShow'])->name('mahasiswa.hasil_ujian.show');

        // Notifications routes for students
        Route::get('/mahasiswa/notifikasi', [NotifikasiController::class, 'mahasiswaIndex'])->name('mahasiswa.notifikasi.index');
        Route::get('/mahasiswa/notifikasi/{id}', [NotifikasiController::class, 'mahasiswaShow'])->name('mahasiswa.notifikasi.show');
        Route::post('/mahasiswa/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('mahasiswa.notifikasi.read');

        // Profile routes
        Route::get('/mahasiswa/profile/edit', [UserController::class, 'editMahasiswa'])->name('mahasiswa.profile.edit');
        Route::post('/mahasiswa/profile/update', [UserController::class, 'updateMahasiswa'])->name('mahasiswa.profile.update');

        // Routes untuk Surat Pernyataan - Mahasiswa
        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            Route::get('/surat-pernyataan', [SuratPernyataanController::class, 'index'])->name('surat-pernyataan.index');
            Route::post('/surat-pernyataan', [SuratPernyataanController::class, 'store'])->name('surat-pernyataan.store');
            Route::delete('/surat-pernyataan/{id}', [SuratPernyataanController::class, 'destroy'])->name('surat-pernyataan.destroy');
        });
    });
});
