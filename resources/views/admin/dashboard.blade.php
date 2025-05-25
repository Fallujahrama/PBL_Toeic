@extends('layouts.template')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card card-hover">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Pendaftaran</p>
                                <h5 class="font-weight-bolder">
                                    {{ App\Models\PendaftaranModel::count() }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-success text-sm font-weight-bolder">
                                        <i class="fa fa-check"></i> {{ App\Models\PendaftaranModel::where('status_verifikasi', 'approved')->count() }}
                                    </span>
                                    terverifikasi
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card card-hover">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Jadwal</p>
                                <h5 class="font-weight-bolder">
                                    {{ App\Models\JadwalModel::count() }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-success text-sm font-weight-bolder">
                                        <i class="fa fa-calendar"></i> {{ App\Models\JadwalModel::where('tanggal', '>=', date('Y-m-d'))->count() }}
                                    </span>
                                    akan datang
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card card-hover">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Hasil Ujian</p>
                                <h5 class="font-weight-bolder">
                                    {{ App\Models\HasilUjianModel::count() }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-info text-sm font-weight-bolder">
                                        <i class="fa fa-file-alt"></i> {{ App\Models\HasilUjianModel::whereMonth('tanggal', date('m'))->count() }}
                                    </span>
                                    bulan ini
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card card-hover">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Mahasiswa</p>
                                <h5 class="font-weight-bolder">
                                    {{ App\Models\MahasiswaModel::count() }}
                                </h5>
                                <p class="mb-0 text-sm">
                                    <span class="text-primary text-sm font-weight-bolder">
                                        <i class="fa fa-users"></i> {{ App\Models\PendaftaranModel::distinct('nim')->count('nim') }}
                                    </span>
                                    terdaftar
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card card-hover h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('verifikasi.index') }}" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <h6 class="mb-0">Verifikasi Pendaftaran</h6>
                                </div>
                                <p class="text-xs text-muted mb-0 mt-1">Verifikasi pendaftaran mahasiswa</p>
                            </div>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                        <a href="{{ route('jadwal.index') }}" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-xs bg-gradient-success text-white rounded-circle shadow me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <h6 class="mb-0">Kelola Jadwal</h6>
                                </div>
                                <p class="text-xs text-muted mb-0 mt-1">Tambah atau edit jadwal ujian</p>
                            </div>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                        <a href="{{ route('hasil_ujian.index') }}" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-xs bg-gradient-warning text-white rounded-circle shadow me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <h6 class="mb-0">Upload Hasil Ujian</h6>
                                </div>
                                <p class="text-xs text-muted mb-0 mt-1">Upload hasil ujian TOEIC</p>
                            </div>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                        <a href="{{ route('notifikasi.index') }}" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-xs bg-gradient-danger text-white rounded-circle shadow me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <h6 class="mb-0">Kelola Notifikasi</h6>
                                </div>
                                <p class="text-xs text-muted mb-0 mt-1">Kirim notifikasi ke mahasiswa</p>
                            </div>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Verifications -->
        <div class="col-lg-4 mb-4">
            <div class="card card-hover h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">
                        <i class="fas fa-hourglass-half me-2 text-warning"></i>
                        Menunggu Verifikasi
                    </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @php
                        $pendingVerifications = App\Models\PendaftaranModel::where('status_verifikasi', 'pending')
                            ->orWhereNull('status_verifikasi')
                            ->with('mahasiswa')
                            ->take(5)
                            ->get();
                    @endphp

                    @if($pendingVerifications->isEmpty())
                        <div class="text-center p-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="mb-0">Tidak ada pendaftaran yang menunggu verifikasi</p>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Mahasiswa</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingVerifications as $pendaftaran)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $pendaftaran->mahasiswa->nama ?? 'N/A' }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $pendaftaran->nim }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y') }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('verifikasi.show', $pendaftaran->id_pendaftaran) }}" class="btn btn-link text-info px-3 mb-0">
                                                    <i class="fas fa-eye text-info me-2"></i>Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('verifikasi.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-list me-2"></i>Lihat Semua
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Account Info & Recent Notifications -->
        <div class="col-lg-4">
            <!-- Account Info -->
            <div class="card card-hover mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">
                        <i class="fas fa-user-circle me-2 text-primary"></i>
                        Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-xl bg-gradient-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <span class="text-white text-lg font-weight-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <p class="text-xs text-muted mb-0">{{ Auth::user()->level->level_nama ?? 'Administrator' }}</p>
                        </div>
                    </div>

                    <div class="info-item mb-2">
                        <span class="text-xs text-muted">Username:</span>
                        <span class="text-sm ms-2">{{ Auth::user()->username }}</span>
                    </div>

                    <div class="info-item mb-2">
                        <span class="text-xs text-muted">No. WhatsApp:</span>
                        <span class="text-sm ms-2">
                            {{ Auth::user()->admin->no_hp ?? '-' }}
                        </span>
                    </div>

                    <div class="info-item mb-3">
                        <span class="text-xs text-muted">Login Terakhir:</span>
                        <span class="text-sm ms-2">{{ \Carbon\Carbon::parse(Auth::user()->last_login ?? Auth::user()->created_at)->format('d M Y H:i') }}</span>
                    </div>

                    <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-user-edit me-2"></i>Edit Profil
                    </a>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="card card-hover">
                <div class="card-header pb-0">
                    <h6 class="mb-0">
                        <i class="fas fa-bell me-2 text-danger"></i>
                        Notifikasi Terbaru
                    </h6>
                </div>
                <div class="card-body p-3">
                    @php
                        $recentNotifications = App\Models\NotifikasiModel::latest()->take(3)->get();
                    @endphp

                    @if($recentNotifications->isEmpty())
                        <div class="text-center py-3">
                            <i class="fas fa-bell-slash fa-2x text-muted mb-3"></i>
                            <p class="mb-0">Belum ada notifikasi</p>
                        </div>
                    @else
                        @foreach($recentNotifications as $notification)
                            <div class="notification-item p-2 mb-2 rounded {{ $loop->first ? 'bg-light' : '' }}">
                                <div class="d-flex align-items-center mb-1">
                                    <div class="icon-shape icon-xs bg-gradient-danger text-white rounded-circle shadow me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <h6 class="text-sm mb-0">{{ Str::limit($notification->judul ?? 'Notifikasi', 30) }}</h6>
                                    <span class="text-xs text-muted ms-auto">{{ \Carbon\Carbon::parse($notification->tanggal)->format('d M') }}</span>
                                </div>
                                <p class="text-xs ms-4 mb-0">{{ Str::limit($notification->pesan, 60) }}</p>
                            </div>
                        @endforeach

                        <div class="text-center mt-3">
                            <a href="{{ route('notifikasi.index') }}" class="btn btn-sm btn-outline-danger w-100">
                                <i class="fas fa-bell me-2"></i>Lihat Semua Notifikasi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Schedule -->
    <div class="row">
        <div class="col-12">
            <div class="card card-hover mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar-day me-2 text-success"></i>
                        Jadwal TOEIC Mendatang
                    </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @php
                        $upcomingSchedules = App\Models\JadwalModel::whereDate('tanggal', '>=', \Carbon\Carbon::today())
                            ->orderBy('tanggal', 'asc')
                            ->take(5)
                            ->get();
                    @endphp

                    @if($upcomingSchedules->isEmpty())
                        <div class="text-center p-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="mb-0">Tidak ada jadwal TOEIC mendatang</p>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Informasi</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">File</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($upcomingSchedules as $jadwal)
                                    <tr>
                                        <td>
                                            <span class="text-xs font-weight-bold mb-0">
                                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold mb-0">
                                                {{ $jadwal->informasi }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($jadwal->file)
                                                <a href="{{ asset('storage/'.$jadwal->file) }}" class="btn btn-sm btn-danger" target="_blank">PDF</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('jadwal.preview', $jadwal->jadwal_id) }}?t={{ time() }}" class="btn btn-link text-info px-2 mb-0" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Jadwal">
                                                <i class="fas fa-eye text-info me-2"></i>Detail Jadwal
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
    .avatar {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-item {
        display: flex;
        align-items: center;
    }

    .notification-item {
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
    }

    .icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
