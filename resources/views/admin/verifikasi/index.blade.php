@extends('layouts.template')

@section('title', 'Verifikasi Pendaftaran - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Verifikasi Pendaftaran</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $page->title ?? 'Verifikasi Pendaftaran' }}</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-success text-white rounded-circle shadow me-2">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h5 class="mb-0">Daftar Pendaftaran TOEIC</h5>
                    </div>
                    <a href="{{ route('verifikasi.create') }}" class="btn btn-sm btn-primary" data-aos="fade-left">
                        <i class="fas fa-plus me-2"></i>Tambah Pendaftaran
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success mx-4 mt-3" role="alert" data-aos="fade-up">
                        <div class="d-flex">
                            <div class="icon icon-shape icon-xs bg-gradient-success text-white rounded-circle shadow me-2">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                <div class="table-responsive p-0 mt-3">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">NIM</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Nama</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Tanggal Daftar</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftarans as $pendaftaran)
                                <tr class="pendaftaran-row fade-in" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $pendaftaran->id }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $pendaftaran->nim }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                @if($pendaftaran->file_foto)
                                                    <img src="{{ asset('storage/' . $pendaftaran->file_foto) }}" alt="Foto" class="avatar-img rounded-circle">
                                                @else
                                                    <div class="avatar-initial rounded-circle bg-primary">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $pendaftaran->mahasiswa->nama ?? 'Data tidak tersedia' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="ps-4">
                                        @if($pendaftaran->status_verifikasi == 'approved')
                                            <span class="badge bg-gradient-success">Disetujui</span>
                                        @elseif($pendaftaran->status_verifikasi == 'rejected')
                                            <span class="badge bg-gradient-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-gradient-warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('verifikasi.show', $pendaftaran->id_pendaftaran) }}" class="btn btn-link text-warning px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                            @if(count($pendaftarans) == 0)
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                                            <h6 class="text-secondary">Belum ada pendaftaran yang perlu diverifikasi</h6>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    .avatar {
        width: 30px;
        height: 30px;
        overflow: hidden;
        position: relative;
    }
    
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-initial {
        width: 100%;
        height: 100%;
        display: flex;
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
