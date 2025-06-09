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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'postlogin'])->name('postlogin');
// Add to routes/web.php
Route::get('register', [App\Http\Controllers\LoginController::class, 'register'])->name('register');
Route::post('register', [App\Http\Controllers\LoginController::class, 'postRegister']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Landing page route
Route::get('/landing', function () {
    return view('landing');
})->name('landing');

Route::middleware('auth')->group(function () {
    // Common routes for all authenticated users
    Route::get('/profile', [UserController::class, 'profilePage'])->name('profile');
    Route::post('/user/editPhoto', [UserController::class, 'editPhoto'])->name('user.editPhoto');

    // Admin routes (AdmUpa and AdmITC)
    Route::middleware(['authorize:AdmUpa,AdmITC,SprAdmin'])->group(function () {
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
        Route::post('jadwal/validate-file', [JadwalController::class, 'validateFile'])->name('jadwal.validateFile');

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
            Route::delete('/surat-pernyataan/template/{id}', [SuratPernyataanController::class, 'deleteTemplate'])->name('surat-pernyataan.delete-template');
        });
    });

    // SuperAdmin only routes
    Route::middleware(['authorize:SprAdmin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            // User Management routes
            Route::get('/users', [UserController::class, 'adminIndex'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{id}/show', [UserController::class, 'show'])->name('users.show');
            Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });

    // Admin ITC specific routes (only AdmITC)
    Route::middleware(['authorize:AdmITC'])->group(function () {
        // Data Mahasiswa Management routes - only for AdmITC
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/mahasiswa', [PendaftaranController::class, 'dataMahasiswa'])->name('mahasiswa.index');
            Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
            Route::get('/mahasiswa/{nim}/show', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
            Route::get('/mahasiswa/{nim}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
            Route::put('/mahasiswa/{nim}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
            Route::delete('/mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
            
            // Export routes for Mahasiswa data - only for AdmITC
            Route::get('/mahasiswa/export/pdf', [MahasiswaController::class, 'exportPDF'])->name('mahasiswa.export.pdf');
            Route::get('/mahasiswa/export/excel', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.export.excel');
        });
    });

    // Routes ONLY for active students (Mhs) - Restricted features
    Route::middleware(['authorize:Mhs'])->group(function () {
        // New registration route - ONLY for active students
        Route::prefix('mahasiswa/pendaftaran')->name('pendaftaran.')->group(function () {
            Route::get('/baru', [PendaftaranController::class, 'createBaru'])->name('baru');
            Route::post('/baru', [PendaftaranController::class, 'storeBaru'])->name('storeBaru');
        });

        // Surat Pernyataan routes - ONLY for active students
        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            Route::get('/surat-pernyataan', [SuratPernyataanController::class, 'index'])->name('surat-pernyataan.index');
            Route::post('/surat-pernyataan', [SuratPernyataanController::class, 'store'])->name('surat-pernyataan.store');
            Route::delete('/surat-pernyataan/{id}', [SuratPernyataanController::class, 'destroy'])->name('surat-pernyataan.destroy');
        });
    });

    // Routes for ALL non-admin users (Mhs, Almn, Dsn, Cvts)
    Route::middleware(['authorize:Mhs,Alum,Dsn,Cvts'])->group(function () {
        // Dashboard
        Route::get('/mahasiswa/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('mahasiswa.dashboard');

        // Pendaftaran routes (except 'baru' which is restricted to active students)
        Route::prefix('mahasiswa/pendaftaran')->name('pendaftaran.')->group(function () {
            Route::get('/', [PendaftaranController::class, 'index'])->name('index');
            Route::get('/lama', [PendaftaranController::class, 'createLama'])->name('lama');
            Route::post('/lama', [PendaftaranController::class, 'storeLama'])->name('lama.store');
            Route::get('/lama/get-mahasiswa/{nim}', [PendaftaranController::class, 'getMahasiswa'])->name('getMahasiswa');
            Route::get('/{id}/show', [PendaftaranController::class, 'showRegistration'])->name('show');
            Route::get('/{nim}/preview/{type}', [PendaftaranController::class, 'previewFile'])->name('preview');
        });

        // Student data management routes
        Route::prefix('mahasiswa/data')->name('mahasiswa.data.')->group(function () {
            Route::get('/{nim}/edit', [PendaftaranController::class, 'editMahasiswa'])->name('edit');
            Route::put('/{nim}', [PendaftaranController::class, 'updateMahasiswa'])->name('update');
            Route::get('/{nim}/show', [PendaftaranController::class, 'showMahasiswa'])->name('show');
        });

        // Jadwal routes for non-admin users
        Route::get('/mahasiswa/jadwal', [JadwalController::class, 'mahasiswaIndex'])->name('mahasiswa.jadwal');
        Route::get('/mahasiswa/jadwal/preview/{id}', [JadwalController::class, 'previewFile'])->name('mahasiswa.jadwal.preview');

        // Hasil Ujian routes for non-admin users
        Route::get('/mahasiswa/hasil-ujian', [HasilUjianController::class, 'mahasiswaIndex'])->name('mahasiswa.hasil_ujian');
        Route::get('/mahasiswa/hasil-ujian/{id}', [HasilUjianController::class, 'mahasiswaShow'])->name('mahasiswa.hasil_ujian.show');

        // Notifications routes for non-admin users
        Route::get('/mahasiswa/notifikasi', [NotifikasiController::class, 'mahasiswaIndex'])->name('mahasiswa.notifikasi.index');
        Route::get('/mahasiswa/notifikasi/{id}', [NotifikasiController::class, 'mahasiswaShow'])->name('mahasiswa.notifikasi.show');
        Route::post('/mahasiswa/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('mahasiswa.notifikasi.read');

        // Profile routes
        Route::get('/mahasiswa/profile/edit', [UserController::class, 'editMahasiswa'])->name('mahasiswa.profile.edit');
        Route::post('/mahasiswa/profile/update', [UserController::class, 'updateMahasiswa'])->name('mahasiswa.profile.update');
    });
});
