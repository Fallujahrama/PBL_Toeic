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
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="fas fa-language fa-6x opacity-8"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="counter-value" data-count="1500">0</div>
                        <div class="counter-title">Peserta Terdaftar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="counter-value" data-count="24">0</div>
                        <div class="counter-title">Jadwal Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="counter-value" data-count="990">0</div>
                        <div class="counter-title">Sertifikat Terbit</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mt-2">
        <!-- Card Info Jadwal -->
        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card info-card shadow animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h6 class="mb-0">Jadwal Tes TOEIC Terdekat</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1 text-dark">Gelombang 1</h6>
                                <p class="text-sm mb-0">20 Mei 2025 - Laboratorium Bahasa, Gedung E</p>
                                <span class="badge bg-gradient-primary mt-2">Pendaftaran Dibuka</span>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1 text-dark">Gelombang 2</h6>
                                <p class="text-sm mb-0">10 Juni 2025 - Laboratorium Bahasa, Gedung E</p>
                                <span class="badge bg-gradient-warning mt-2">Segera Dibuka</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ url('/tables') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Jadwal</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Info Persyaratan -->
        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card info-card shadow animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-success text-white rounded-circle shadow me-2">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h6 class="mb-0">Persyaratan Pendaftaran</h6>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Mahasiswa aktif dengan KTM yang masih berlaku</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Upload scan KTM (Kartu Tanda Mahasiswa)</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Biaya pendaftaran: Rp150.000 (transfer bank)</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Mengisi formulir pendaftaran online</span>
                        </li>
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline-success">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcement Card -->
    <div class="row" data-aos="fade-up" data-aos-delay="300">
        <div class="col-12 mb-4">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="d-flex">
                        <div class="icon icon-shape icon-lg bg-gradient-info text-white rounded-circle shadow me-3">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Pengumuman Penting</h5>
                            <p class="mb-0">Bagi seluruh peserta TOEIC, harap membawa kartu identitas dan bukti pembayaran saat hari pelaksanaan tes. Peserta diharapkan hadir 30 menit sebelum tes dimulai untuk proses registrasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
