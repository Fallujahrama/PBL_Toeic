@extends('layouts.template')

@section('title', 'Welcome to TOEIC Center')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                @foreach($breadcrumb->list as $key => $value)
                    @if ($key < count($breadcrumb->list) - 1)
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-dark" href="#">{{ $value }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $value }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
        <h6 class="font-weight-bolder mb-0">{{ $breadcrumb->title }}</h6>
    </div>

    <!-- Welcome Header -->
    <div class="welcome-header card-gradient-primary text-white" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="text-white mb-3">Selamat Datang di Sistem Pendaftaran TOEIC</h3>
                <p class="mb-4 opacity-8">Tingkatkan kemampuan bahasa Inggris Anda dan dapatkan sertifikasi internasional yang diakui di seluruh dunia. Silakan cek jadwal terbaru, persyaratan, dan segera daftarkan dirimu untuk mengikuti tes TOEIC!</p>
                <div class="d-flex flex-wrap gap-2">
                    @if(Auth::check() && (Auth::user()->level_id == 1 || Auth::user()->level_id == 2))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm mb-0 me-1 pulse">
                            <i class="fas fa-tachometer-alt me-1"></i> Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-light btn-sm mb-0 me-1 pulse">
                            <i class="fas fa-user-plus me-1"></i> Daftar Sekarang
                        </a>
                    @endif
                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline-light btn-sm mb-0">
                        <i class="fas fa-calendar-alt me-1"></i> Lihat Jadwal
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="fas fa-language fa-6x opacity-8"></i>
            </div>
        </div>
    </div>

    @if(!Auth::check() || Auth::user()->level_id == 3)
    <!-- Registration Process - Only shown to students or guests -->
    <div class="row mt-4">
        <div class="col-12 mb-4" data-aos="fade-up">
            <div class="card animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h6 class="mb-0">Proses Pendaftaran TOEIC</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">1</span>
                                </div>
                                <h6>Pilih Jenis Pendaftaran</h6>
                                <p class="text-sm mb-0">Pilih antara pendaftaran pertama atau pendaftaran kedua sesuai status Anda</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">2</span>
                                </div>
                                <h6>Isi Formulir</h6>
                                <p class="text-sm mb-0">Lengkapi formulir dengan data diri dan upload dokumen yang diperlukan</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">3</span>
                                </div>
                                <h6>Pembayaran</h6>
                                <p class="text-sm mb-0">Lakukan pembayaran biaya pendaftaran sebesar Rp150.000 via transfer bank</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">4</span>
                                </div>
                                <h6>Konfirmasi</h6>
                                <p class="text-sm mb-0">Dapatkan konfirmasi pendaftaran dan jadwal tes melalui email dan WhatsApp</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Mulai Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Admin Dashboard Summary - Only shown to admins -->
    <div class="row mt-4">
        <div class="col-12 mb-4" data-aos="fade-up">
            <div class="card animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <h6 class="mb-0">Admin Dashboard</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="card p-4 text-center h-100 shadow-sm animate-card" style="border: 1px solid var(--dark-border); background-color: var(--dark-card); cursor: pointer;" onclick="window.location='{{ route('verifikasi.index') }}'">
                                <i class="fas fa-clipboard-list fa-3x mb-3 text-primary"></i>
                                <h4>Kelola Pendaftaran</h4>
                                <p>Verifikasi dan kelola pendaftaran mahasiswa</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="card p-4 text-center h-100 shadow-sm animate-card" style="border: 1px solid var(--dark-border); background-color: var(--dark-card); cursor: pointer;" onclick="window.location='{{ route('jadwal.index') }}'">
                                <i class="fas fa-calendar-alt fa-3x mb-3 text-warning"></i>
                                <h4>Kelola Jadwal</h4>
                                <p>Atur jadwal tes TOEIC</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="card p-4 text-center h-100 shadow-sm animate-card" style="border: 1px solid var(--dark-border); background-color: var(--dark-card); cursor: pointer;" onclick="window.location='{{ route('mahasiswa.index') }}'">
                                <i class="fas fa-users fa-3x mb-3 text-success"></i>
                                <h4>Data Mahasiswa</h4>
                                <p>Lihat dan kelola data mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('js')
<script>
    // Add pulse effect to the "Daftar Sekarang" button
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const registerBtn = document.querySelector('.welcome-header .btn-light');
            if (registerBtn) {
                registerBtn.classList.add('pulse');
            }
        }, 2000);
    });
</script>
@endpush
