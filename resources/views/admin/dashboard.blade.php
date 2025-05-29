@extends('layouts.template')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header text-white position-relative overflow-hidden">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="welcome-content">
                            <h1 class="display-6 fw-bold mb-2">Selamat Datang di Sistem Pendaftaran TOEIC, {{ Auth::user()->name }}!</h1>
                            <p class="lead mb-1 opacity-9">Kelola sistem TOEIC dengan mudah dan efisien</p>
                            <small class="opacity-8 d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ \Carbon\Carbon::now()->format('l, d F Y') }}
                            </small>
                        </div>
                    </div>

                </div>
                <!-- Decorative elements -->

            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card border-start border-primary border-4">
                <div class="stat-card-content">
                    <div class="stat-card-info">
                        <div class="stat-number text-primary">{{ App\Models\PendaftaranModel::count() }}</div>
                        <div class="stat-label">Total Pendaftaran</div>
                        <div class="stat-meta">
                            <span class="badge bg-success-light text-success">
                                <i class="fas fa-check me-1"></i>{{ App\Models\PendaftaranModel::where('status_verifikasi', 'approved')->count() }} Terverifikasi
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-primary-light text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card border-start border-success border-4">
                <div class="stat-card-content">
                    <div class="stat-card-info">
                        <div class="stat-number text-success">{{ App\Models\JadwalModel::count() }}</div>
                        <div class="stat-label">Jadwal Ujian</div>
                        <div class="stat-meta">
                            <span class="badge bg-info-light text-info">
                                <i class="fas fa-clock me-1"></i>{{ App\Models\JadwalModel::where('tanggal', '>=', date('Y-m-d'))->count() }} Akan Datang
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-success-light text-success">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card border-start border-warning border-4">
                <div class="stat-card-content">
                    <div class="stat-card-info">
                        <div class="stat-number text-warning">{{ App\Models\HasilUjianModel::count() }}</div>
                        <div class="stat-label">Hasil Ujian</div>
                        <div class="stat-meta">
                            <span class="badge bg-warning-light text-warning">
                                <i class="fas fa-chart-line me-1"></i>{{ App\Models\HasilUjianModel::whereMonth('tanggal', date('m'))->count() }} Bulan Ini
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-warning-light text-warning">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card border-start border-info border-4">
                <div class="stat-card-content">
                    <div class="stat-card-info">
                        <div class="stat-number text-info">{{ App\Models\SuratPernyataanModel::count() }}</div>
                        <div class="stat-label">Surat Pernyataan</div>
                        <div class="stat-meta">
                            <span class="badge bg-danger-light text-danger">
                                <i class="fas fa-hourglass-half me-1"></i>{{ App\Models\SuratPernyataanModel::where('status', 'pending')->count() }} Menunggu
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon bg-info-light text-info">
                        <i class="fas fa-file-signature"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm bg-gradient-warning text-white rounded-circle me-3">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Aksi Cepat</h6>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('verifikasi.index') }}" class="quick-action-card text-decoration-none">
                                <div class="quick-action-content">
                                    <div class="quick-action-icon bg-gradient-primary">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="quick-action-info">
                                        <h6 class="quick-action-title">Verifikasi Pendaftaran</h6>
                                        <p class="quick-action-desc">Verifikasi pendaftaran mahasiswa baru</p>
                                    </div>
                                </div>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('jadwal.index') }}" class="quick-action-card text-decoration-none">
                                <div class="quick-action-content">
                                    <div class="quick-action-icon bg-gradient-success">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <div class="quick-action-info">
                                        <h6 class="quick-action-title">Kelola Jadwal</h6>
                                        <p class="quick-action-desc">Tambah atau edit jadwal ujian TOEIC</p>
                                    </div>
                                </div>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('hasil_ujian.index') }}" class="quick-action-card text-decoration-none">
                                <div class="quick-action-content">
                                    <div class="quick-action-icon bg-gradient-warning">
                                        <i class="fas fa-upload"></i>
                                    </div>
                                    <div class="quick-action-info">
                                        <h6 class="quick-action-title">Upload Hasil</h6>
                                        <p class="quick-action-desc">Upload hasil ujian TOEIC</p>
                                    </div>
                                </div>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.surat-pernyataan.index') }}" class="quick-action-card text-decoration-none">
                                <div class="quick-action-content">
                                    <div class="quick-action-icon bg-gradient-info">
                                        <i class="fas fa-file-signature"></i>
                                    </div>
                                    <div class="quick-action-info">
                                        <h6 class="quick-action-title">Surat Pernyataan</h6>
                                        <p class="quick-action-desc">Kelola surat pernyataan mahasiswa</p>
                                    </div>
                                </div>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Pending Verifications -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape icon-sm bg-gradient-warning text-white rounded-circle me-3">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Menunggu Verifikasi</h6>
                        </div>
                        @php
                            $pendingCount = App\Models\PendaftaranModel::where('status_verifikasi', 'pending')->orWhereNull('status_verifikasi')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="badge bg-warning">{{ $pendingCount }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-3">
                    @php
                        $pendingVerifications = App\Models\PendaftaranModel::where('status_verifikasi', 'pending')
                            ->orWhereNull('status_verifikasi')
                            ->with('mahasiswa')
                            ->take(6)
                            ->get();
                    @endphp

                    @if($pendingVerifications->isEmpty())
                        <div class="text-center py-5">
                            <div class="icon-shape icon-xl bg-success-light text-success rounded-circle mx-auto mb-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h5 class="text-success">Semua Terverifikasi!</h5>
                            <p class="text-muted mb-0">Tidak ada pendaftaran yang menunggu verifikasi</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($pendingVerifications as $pendaftaran)
                                <div class="col-md-6">
                                    <div class="pending-item">
                                        <div class="d-flex align-items-center">
                                            <div class="pending-avatar">
                                                <div class="avatar bg-gradient-primary text-white">
                                                    {{ substr($pendaftaran->mahasiswa->nama ?? 'N', 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="pending-info flex-grow-1">
                                                <h6 class="mb-1">{{ $pendaftaran->mahasiswa->nama ?? 'N/A' }}</h6>
                                                <p class="text-muted small mb-1">{{ $pendaftaran->nim }}</p>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($pendaftaran->created_at)->diffForHumans() }}</small>
                                            </div>
                                            <div class="pending-action">
                                                <a href="{{ route('verifikasi.show', $pendaftaran->id_pendaftaran) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('verifikasi.index') }}" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>Lihat Semua Verifikasi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm bg-gradient-info text-white rounded-circle me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Aktivitas Terbaru</h6>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="timeline">
                        @php
                            $recentActivities = collect([
                                (object)[
                                    'type' => 'pendaftaran',
                                    'count' => App\Models\PendaftaranModel::whereDate('created_at', today())->count(),
                                    'label' => 'Pendaftaran hari ini',
                                    'icon' => 'fas fa-user-plus',
                                    'color' => 'primary'
                                ],
                                (object)[
                                    'type' => 'verifikasi',
                                    'count' => App\Models\PendaftaranModel::where('status_verifikasi', 'approved')->whereDate('updated_at', today())->count(),
                                    'label' => 'Verifikasi hari ini',
                                    'icon' => 'fas fa-check',
                                    'color' => 'success'
                                ],
                                (object)[
                                    'type' => 'surat',
                                    'count' => App\Models\SuratPernyataanModel::whereDate('created_at', today())->count(),
                                    'label' => 'Surat pernyataan hari ini',
                                    'icon' => 'fas fa-file-signature',
                                    'color' => 'info'
                                ]
                            ]);
                        @endphp

                        @foreach($recentActivities as $activity)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $activity->color }}">
                                    <i class="{{ $activity->icon }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-medium">{{ $activity->label }}</span>
                                        <span class="badge bg-{{ $activity->color }}-light text-{{ $activity->color }}">{{ $activity->count }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted small">Total mahasiswa terdaftar</span>
                            <span class="fw-bold text-primary">{{ App\Models\MahasiswaModel::count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Schedule -->
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
                            ->take(5)
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
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 text-uppercase text-xs font-weight-bolder opacity-7">Tanggal</th>
                                        <th class="border-0 text-uppercase text-xs font-weight-bolder opacity-7">Informasi</th>
                                        <th class="border-0 text-uppercase text-xs font-weight-bolder opacity-7">File</th>
                                        <th class="border-0 text-uppercase text-xs font-weight-bolder opacity-7">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($upcomingSchedules as $jadwal)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-xs bg-primary-light text-primary rounded me-2">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                                <span class="text-sm fw-medium">
                                                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $jadwal->informasi }}</span>
                                        </td>
                                        <td>
                                            @if($jadwal->file)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-file-pdf me-1"></i>PDF
                                                </span>
                                            @else
                                                <span class="badge bg-light text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('jadwal.preview', $jadwal->jadwal_id) }}?t={{ time() }}" class="btn btn-sm btn-outline-info" target="_blank">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

    .pending-item {
        padding: 1rem;
        border-radius: 0.75rem;
        background: var(--light-hover);
        border: 1px solid var(--light-border);
        transition: all 0.3s ease;
    }

    .pending-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: var(--bs-primary);
    }

    .pending-avatar {
        margin-right: 1rem;
    }

    .timeline {
        position: relative;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-marker {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .timeline-content {
        flex: 1;
        padding: 0.5rem 0;
    }

    .quick-action-card {
        display: block;
        padding: 1.5rem;
        border-radius: 1rem;
        background: white;
        border: 1px solid var(--light-border);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: transparent;
        text-decoration: none;
    }

    .quick-action-content {
        display: flex;
        align-items: flex-start;
    }

    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .quick-action-info {
        flex: 1;
    }

    .quick-action-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--light-text);
    }

    .quick-action-desc {
        font-size: 0.875rem;
        color: var(--light-text-muted);
        margin-bottom: 0;
        line-height: 1.4;
    }

    .quick-action-arrow {
        position: absolute;
        top: 1rem;
        right: 1rem;
        color: var(--light-text-muted);
        font-size: 0.875rem;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .quick-action-card:hover .quick-action-arrow {
        opacity: 1;
        transform: translateX(4px);
    }

    .bg-gradient-purple {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    }

    .bg-purple-light {
        background-color: rgba(102, 126, 234, 0.1);
    }

    .text-purple {
        color: #667eea;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Animate stats on load
        $('.stat-number').each(function() {
            const $this = $(this);
            const countTo = parseInt($this.text());
            
            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(this.countNum);
                }
            });
        });

        // Add staggered fade in animation
        $('.stat-card').each(function(index) {
            $(this).css('opacity', '0').delay(index * 150).animate({
                opacity: 1
            }, 600);
        });

        $('.quick-action-card').each(function(index) {
            $(this).css('opacity', '0').delay(800 + (index * 100)).animate({
                opacity: 1
            }, 500);
        });

        // Add hover effects to pending items
        $('.pending-item').hover(
            function() {
                $(this).find('.pending-action .btn').removeClass('btn-outline-primary').addClass('btn-primary');
            },
            function() {
                $(this).find('.pending-action .btn').removeClass('btn-primary').addClass('btn-outline-primary');
            }
        );
    });
</script>
@endpush
