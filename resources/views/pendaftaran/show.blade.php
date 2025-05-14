@extends('layouts.template')

@section('title', 'Detail Pendaftaran - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('pendaftaran.index') }}">Pendaftaran</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Detail Pendaftaran</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-info text-white rounded-circle shadow me-2">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5 class="mb-0">Detail Pendaftaran TOEIC</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="info-card">
                            <div class="card-header">
                                <h6>Informasi Pendaftaran</h6>
                            </div>
                            <div class="card-body">
                                <div class="profile-info-item fade-in fade-in-1">
                                    <div class="profile-info-label">
                                        <i class="fas fa-hashtag me-2"></i>ID Pendaftaran
                                    </div>
                                    <div class="profile-info-value">
                                        {{ $pendaftaran->id_pendaftaran }}
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-2">
                                    <div class="profile-info-label">
                                        <i class="fas fa-id-badge me-2"></i>NIM
                                    </div>
                                    <div class="profile-info-value">
                                        {{ $pendaftaran->nim }}
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-3">
                                    <div class="profile-info-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Tanggal Daftar
                                    </div>
                                    <div class="profile-info-value">
                                        {{ $pendaftaran->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-4">
                                    <div class="profile-info-label">
                                        <i class="fas fa-clock me-2"></i>Terakhir Diupdate
                                    </div>
                                    <div class="profile-info-value">
                                        {{ $pendaftaran->updated_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="info-card">
                            <div class="card-header">
                                <h6>Dokumen Pendaftaran</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="document-card fade-in fade-in-1">
                                            <div class="document-icon">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                            <div class="document-info">
                                                <h6>KTP</h6>
                                                <a href="{{ asset('storage/' . $pendaftaran->file_ktp) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <div class="document-card fade-in fade-in-2">
                                            <div class="document-icon">
                                                <i class="fas fa-address-card"></i>
                                            </div>
                                            <div class="document-info">
                                                <h6>KTM</h6>
                                                <a href="{{ asset('storage/' . $pendaftaran->file_ktm) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <div class="document-card fade-in fade-in-3">
                                            <div class="document-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="document-info">
                                                <h6>Foto</h6>
                                                <a href="{{ asset('storage/' . $pendaftaran->file_foto) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('pendaftaran.edit', $pendaftaran->id_pendaftaran) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <form action="{{ route('pendaftaran.destroy', $pendaftaran->id_pendaftaran) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pendaftaran ini?')">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .document-card {
        background-color: var(--dark-hover);
        border-radius: 10px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid var(--dark-border);
    }
    
    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-color: #3b82f6;
    }
    
    .document-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--dark-gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    
    .document-icon i {
        font-size: 1.5rem;
        color: white;
    }
    
    .document-info h6 {
        margin-bottom: 10px;
        color: var(--dark-text);
    }
</style>
@endpush
