@extends('layouts.template')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header text-white position-relative overflow-hidden">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="welcome-content">
                            <h1 class="text-white display-6 fw-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                            <p class="lead mb-1 opacity-9">Kelola pendaftaran TOEIC Anda dengan mudah</p>
                            <small class="opacity-8 d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ \Carbon\Carbon::now()->format('l, d F Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="welcome-icon">

                        </div>
                    </div>
                </div>
                <!-- Decorative elements -->

            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        @php
            $userRole = Auth::user()->level->level_kode ?? null;
            $isStudent = $userRole === 'Mhs';
            $isNewUserType = in_array($userRole, ['Almn', 'Dsn', 'Cvts']);
        @endphp

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('pendaftaran.index') }}" class="feature-card feature-card-primary text-decoration-none">
                <div class="feature-card-content">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="feature-info">
                        <h5 class="feature-title">Pendaftaran TOEIC</h5>
                        <p class="feature-desc">Daftar ujian TOEIC baru</p>
                        <div class="feature-btn">
                            <span class="btn-text">Daftar Sekarang</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </div>
                <div class="feature-bg"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('mahasiswa.jadwal') }}" class="feature-card feature-card-success text-decoration-none">
                <div class="feature-card-content">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="feature-info">
                        <h5 class="feature-title">Jadwal TOEIC</h5>
                        <p class="feature-desc">Lihat jadwal ujian TOEIC</p>
                        <div class="feature-btn">
                            <span class="btn-text">Lihat Jadwal</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </div>
                <div class="feature-bg"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('mahasiswa.hasil_ujian') }}" class="feature-card feature-card-warning text-decoration-none">
                <div class="feature-card-content">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="feature-info">
                        <h5 class="feature-title">Hasil Ujian</h5>
                        <p class="feature-desc">Lihat hasil ujian TOEIC</p>
                        <div class="feature-btn">
                            <span class="btn-text">Lihat Hasil</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </div>
                <div class="feature-bg"></div>
            </a>
        </div>

        @if($isStudent)
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('mahasiswa.surat-pernyataan.index') }}" class="feature-card feature-card-purple text-decoration-none">
                <div class="feature-card-content">
                    <div class="feature-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="feature-info">
                        <h5 class="feature-title">Surat Pernyataan</h5>
                        <p class="feature-desc">Upload surat pernyataan</p>
                        <div class="feature-btn">
                            <span class="btn-text">Upload Dokumen</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </div>
                <div class="feature-bg"></div>
            </a>
        </div>
        @endif
    </div>

    <div class="row g-4">
        <!-- Status Pendaftaran -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm bg-gradient-primary text-white rounded-circle me-3">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Status Pendaftaran Anda</h6>
                    </div>
                </div>
                <div class="card-body pt-3">
                    @php
                        $user = auth()->user();
                        $mahasiswa = App\Models\MahasiswaModel::where('nim', $user->username)->first();
                        $pendaftaran = $mahasiswa ? App\Models\PendaftaranModel::where('nim', $mahasiswa->nim)->latest()->first() : null;
                        $suratPernyataan = $mahasiswa ? App\Models\SuratPernyataanModel::where('nim', $mahasiswa->nim)->latest()->first() : null;
                    @endphp

                    @if($pendaftaran || $suratPernyataan)
                        <div class="status-timeline">
                            @if($pendaftaran)
                                <div class="status-item">
                                    <div class="status-marker
                                        @if($pendaftaran->status_verifikasi == 'approved') bg-success
                                        @elseif($pendaftaran->status_verifikasi == 'rejected') bg-danger
                                        @else bg-warning @endif">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <div class="status-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Pendaftaran TOEIC</h6>
                                                <p class="text-muted small mb-2">{{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y H:i') }}</p>
                                            </div>
                                            <div>
                                                @if($pendaftaran->status_verifikasi == 'approved')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Disetujui
                                                    </span>
                                                @elseif($pendaftaran->status_verifikasi == 'rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Ditolak
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($pendaftaran->status_verifikasi == 'approved')
                                            <div class="alert alert-success alert-sm mt-2">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Pendaftaran Anda telah disetujui. Silakan cek jadwal ujian.
                                            </div>
                                        @elseif($pendaftaran->status_verifikasi == 'rejected')
                                            <div class="alert alert-danger alert-sm mt-2">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                Pendaftaran ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($pendaftaran)
                                <div class="status-item">
                                    <!-- Pendaftaran status content -->
                                </div>
                            @endif

                            @if($isStudent && $suratPernyataan)
                                <div class="status-item">
                                    <div class="status-marker
                                        @if($suratPernyataan->status == 'valid') bg-success
                                        @elseif($suratPernyataan->status == 'rejected') bg-danger
                                        @else bg-warning @endif">
                                        <i class="fas fa-file-signature"></i>
                                    </div>
                                    <div class="status-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Surat Pernyataan</h6>
                                                <p class="text-muted small mb-2">{{ \Carbon\Carbon::parse($suratPernyataan->created_at)->format('d M Y H:i') }}</p>
                                            </div>
                                            <div>
                                                @if($suratPernyataan->status == 'valid')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Valid
                                                    </span>
                                                @elseif($suratPernyataan->status == 'rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Ditolak
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>Menunggu Validasi
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="icon-shape icon-xl bg-info-light text-info rounded-circle mx-auto mb-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <h5 class="text-info">Belum Ada Pendaftaran</h5>
                            <p class="text-muted mb-4">Mulai dengan mendaftar ujian TOEIC atau upload surat pernyataan</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Daftar TOEIC
                                </a>
                                @if($isStudent)
                                <a href="{{ route('mahasiswa.surat-pernyataan.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-upload me-2"></i>Upload Surat
                                </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile & Quick Links -->
        <div class="col-lg-4">
            <!-- Profile Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm bg-gradient-primary text-white rounded-circle me-3">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Profil Saya</h6>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="profile-header text-center mb-3">
                        <div class="avatar avatar-xl bg-gradient-primary text-white mx-auto mb-2">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                        <p class="text-muted small">NIM: {{ Auth::user()->username }}</p>
                    </div>



                    <a href="{{ route('profile') }}" class="btn btn-outline-primary w-100 mt-3">
                        <i class="fas fa-user-edit me-2"></i>Edit Profil
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm bg-gradient-success text-white rounded-circle me-3">
                            <i class="fas fa-link"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Tautan Cepat</h6>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="quick-links">
                        <a href="{{ route('mahasiswa.notifikasi.index') }}" class="quick-link-item">
                            <div class="quick-link-icon bg-danger-light text-danger">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="quick-link-info">
                                <h6 class="mb-0">Notifikasi</h6>
                                <small class="text-muted">Lihat notifikasi terbaru</small>
                            </div>
                            <div class="quick-link-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                        <a href="{{ route('mahasiswa.jadwal') }}" class="quick-link-item">
                            <div class="quick-link-icon bg-success-light text-success">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="quick-link-info">
                                <h6 class="mb-0">Jadwal Ujian</h6>
                                <small class="text-muted">Cek jadwal ujian mendatang</small>
                            </div>
                            <div class="quick-link-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                        <a href="{{ route('mahasiswa.hasil_ujian') }}" class="quick-link-item">
                            <div class="quick-link-icon bg-warning-light text-warning">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="quick-link-info">
                                <h6 class="mb-0">Hasil Ujian</h6>
                                <small class="text-muted">Lihat hasil ujian Anda</small>
                            </div>
                            <div class="quick-link-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Schedules -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm bg-gradient-success text-white rounded-circle me-3">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Jadwal TOEIC Mendatang</h6>
                    </div>
                </div>
                <div class="card-body pt-3">
                    @php
                        $upcomingSchedules = App\Models\JadwalModel::whereDate('tanggal', '>=', \Carbon\Carbon::today())
                            ->orderBy('tanggal', 'asc')
                            ->take(3)
                            ->get();
                    @endphp

                    @if($upcomingSchedules->isEmpty())
                        <div class="text-center py-4">
                            <div class="icon-shape icon-xl bg-secondary-light text-secondary rounded-circle mx-auto mb-3">
                                <i class="fas fa-calendar-times fa-2x"></i>
                            </div>
                            <h6 class="text-secondary">Tidak Ada Jadwal</h6>
                            <p class="text-muted mb-0">Tidak ada jadwal TOEIC mendatang</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($upcomingSchedules as $jadwal)
                                <div class="col-md-4">
                                    <div class="schedule-card">
                                        <div class="schedule-header">
                                            <div class="schedule-icon bg-gradient-success text-white">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div class="schedule-date">
                                                <h6 class="mb-0">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</h6>
                                                <small>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('M Y') }}</small>
                                            </div>
                                        </div>
                                        <div class="schedule-body">
                                            <h6 class="schedule-title">{{ $jadwal->informasi }}</h6>
                                            @if($jadwal->file)
                                                <a href="{{ asset('storage/'.$jadwal->file) }}" class="btn btn-sm btn-primary w-100 mt-2" target="_blank">
                                                    <i class="fas fa-download me-1"></i>Download PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .icon-xxl {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }

    .backdrop-blur {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* Feature Cards */
    .feature-card {
        position: relative;
        display: block;
        padding: 2rem;
        border-radius: 1.5rem;
        background: white;
        border: 4px solid var(--light-border);
        transition: all 0.4s ease;
        overflow: hidden;
        min-height: 200px;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        border-color: transparent;
        text-decoration: none;
    }

    .feature-card-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .feature-icon {
        width: 64px;
        height: 64px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .feature-card-primary .feature-icon {
        background: var(--gradient-primary);
    }

    .feature-card-success .feature-icon {
        background: var(--gradient-success);
    }

    .feature-card-warning .feature-icon {
        background: var(--gradient-warning);
    }

    .feature-card-purple .feature-icon {
        background: var(--gradient-purple);
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--light-text);
    }

    .feature-desc {
        color: var(--light-text-muted);
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .feature-btn {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--bs-primary);
        font-size: 0.9rem;
    }

    .feature-card-success .feature-btn {
        color: var(--bs-success);
    }

    .feature-card-warning .feature-btn {
        color: var(--bs-warning);
    }

    .feature-card-purple .feature-btn {
        color: var(--bs-purple);
    }

    .feature-bg {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 1;
    }

    .feature-card-primary .feature-bg {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
    }

    .feature-card-success .feature-bg {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(132, 204, 22, 0.05) 100%);
    }

    .feature-card-warning .feature-bg {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.05) 0%, rgba(251, 191, 36, 0.05) 100%);
    }

    .feature-card-purple .feature-bg {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.05) 0%, rgba(217, 70, 239, 0.05) 100%);
    }

    .feature-card:hover .feature-bg {
        opacity: 1;
    }

    /* Status Timeline */
    .status-timeline {
        position: relative;
    }

    .status-item {
        display: flex;
        margin-bottom: 2rem;
        position: relative;
    }

    .status-item:last-child {
        margin-bottom: 0;
    }

    .status-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 20px;
        top: 40px;
        bottom: -32px;
        width: 2px;
        background: var(--light-border);
    }

    .status-marker {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        margin-right: 1rem;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .status-content {
        flex: 1;
        background: var(--light-hover);
        padding: 1.5rem;
        border-radius: 1rem;
        border: 1px solid var(--light-border);
    }

    .alert-sm {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    /* Profile Items */
    .profile-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--light-border);
    }

    .profile-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .profile-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .profile-info {
        flex: 1;
    }

    /* Quick Links */
    .quick-link-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        border: 1px solid transparent;
    }

    .quick-link-item:hover {
        background: var(--light-hover);
        border-color: var(--light-border);
        text-decoration: none;
        color: inherit;
        transform: translateX(4px);
    }

    .quick-link-icon {
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .quick-link-info {
        flex: 1;
    }

    .quick-link-arrow {
        color: var(--light-text-muted);
        font-size: 0.875rem;
    }

    /* Schedule Cards */
    .schedule-card {
        background: white;
        border: 1px solid var(--light-border);
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
        height: 100%;
    }

    .schedule-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--bs-primary);
    }

    .schedule-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .schedule-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .schedule-date h6 {
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1;
    }

    .schedule-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--light-text);
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Add staggered fade in animation
        $('.feature-card').each(function(index) {
            $(this).css('opacity', '0').delay(index * 200).animate({
                opacity: 1
            }, 600);
        });

        // Add hover effects to feature cards
        $('.feature-card').hover(
            function() {
                $(this).find('.feature-btn i').addClass('fa-bounce');
            },
            function() {
                $(this).find('.feature-btn i').removeClass('fa-bounce');
            }
        );

        // Add animation to status items
        $('.status-item').each(function(index) {
            $(this).css('opacity', '0').delay(800 + (index * 300)).animate({
                opacity: 1
            }, 500);
        });

        // Add hover effects to quick links
        $('.quick-link-item').hover(
            function() {
                $(this).find('.quick-link-arrow').addClass('text-primary');
            },
            function() {
                $(this).find('.quick-link-arrow').removeClass('text-primary');
            }
        );
    });
</script>
@endpush
