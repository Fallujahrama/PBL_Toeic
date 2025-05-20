@extends('layouts.template')

@section('title', 'Detail Jadwal - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('jadwal.index') }}">Jadwal</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Detail Jadwal</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-info text-white rounded-circle shadow me-2">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h5 class="mb-0">Informasi Jadwal</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Informasi Jadwal -->
                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="info-card">
                            <div class="card-header">
                                <h6>Detail Jadwal</h6>
                            </div>
                            <div class="card-body">
                                <div class="profile-info-item fade-in fade-in-1">
                                    <div class="profile-info-label">
                                        <i class="fas fa-hashtag me-2"></i>ID Jadwal
                                    </div>
                                    <div class="profile-info-value">
                                        {{ $jadwal->jadwal_id }}
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-2">
                                    <div class="profile-info-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Tanggal
                                    </div>
                                    <div class="profile-info-value">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-3">
                                    <div class="profile-info-label">
                                        <i class="fas fa-info-circle me-2"></i>Informasi
                                    </div>
                                    <div class="profile-info-value">
                                        {{ $jadwal->informasi }}
                                    </div>
                                </div>
                                @if($jadwal->file_info)
                                <div class="profile-info-item fade-in fade-in-4">
                                    <div class="profile-info-label">
                                        <i class="fas fa-file me-2"></i>File
                                    </div>
                                    <div class="profile-info-value">
                                        @php
                                            $extension = pathinfo($jadwal->file_info, PATHINFO_EXTENSION);
                                            $fileName = basename($jadwal->file_info);
                                        @endphp
                                        
                                        @if(strtolower($extension) === 'pdf')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-file-pdf me-1"></i>PDF
                                            </span>
                                        @elseif(in_array(strtolower($extension), ['doc', 'docx']))
                                            <span class="badge bg-primary">
                                                <i class="fas fa-file-word me-1"></i>Word
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-file me-1"></i>{{ strtoupper($extension) }}
                                            </span>
                                        @endif
                                        {{ $fileName }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="400">
                            <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('jadwal.edit', $jadwal->jadwal_id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <button type="button" class="btn btn-danger delete-btn" data-id="{{ $jadwal->jadwal_id }}">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Preview File -->
                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                        @if($jadwal->file_info)
                            @php
                                $extension = pathinfo($jadwal->file_info, PATHINFO_EXTENSION);
                            @endphp
                            
                            @if(strtolower($extension) === 'pdf')
                                <div class="file-preview-container fade-in fade-in-5">
                                    <div class="file-preview-header">
                                        <h6>Preview Dokumen</h6>
                                    </div>
                                    <div class="file-preview-content">
                                        <embed 
                                            src="{{ route('jadwal.preview', $jadwal->jadwal_id) }}" 
                                            type="application/pdf" 
                                            width="100%" 
                                            height="600px"
                                            class="pdf-viewer">
                                    </div>
                                </div>
                            @else
                                <div class="file-preview-container fade-in fade-in-5">
                                    <div class="file-preview-header">
                                        <h6>Preview Dokumen</h6>
                                    </div>
                                    <div class="file-preview-content">
                                        <div class="doc-preview-placeholder">
                                            @if(in_array(strtolower($extension), ['doc', 'docx']))
                                                <div class="doc-icon-container">
                                                    <i class="fas fa-file-word fa-5x text-primary"></i>
                                                </div>
                                                <h4 class="doc-filename mt-3">{{ basename($jadwal->file_info) }}</h4>
                                                <p class="text-center">File Word tidak dapat ditampilkan secara langsung di browser.<br>Silakan download untuk melihat isinya.</p>
                                            @else
                                                <div class="doc-icon-container">
                                                    <i class="fas fa-file fa-5x text-secondary"></i>
                                                </div>
                                                <h4 class="doc-filename mt-3">{{ basename($jadwal->file_info) }}</h4>
                                                <p class="text-center">File tidak dapat ditampilkan secara langsung di browser.<br>Silakan download untuk melihat isinya.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="file-preview-container fade-in fade-in-5">
                                <div class="file-preview-header">
                                    <h6>Preview Dokumen</h6>
                                </div>
                                <div class="file-preview-content">
                                    <div class="doc-preview-placeholder">
                                        <div class="doc-icon-container">
                                            <i class="fas fa-file-excel fa-5x text-success"></i>
                                        </div>
                                        <h4 class="doc-filename mt-3">Tidak ada file</h4>
                                        <p class="text-center">Tidak ada file yang tersedia untuk jadwal ini.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus jadwal ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .info-card {
        background-color: var(--dark-card);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    
    .info-card .card-header {
        padding: 1rem;
        border-bottom: 1px solid var(--dark-border);
    }
    
    .info-card .card-body {
        padding: 1rem;
    }
    
    .profile-info-item {
        display: flex;
        margin-bottom: 1rem;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .profile-info-item:hover {
        background-color: var(--dark-hover);
    }
    
    .profile-info-label {
        width: 40%;
        font-weight: 600;
        color: var(--dark-text);
    }
    
    .profile-info-value {
        width: 60%;
    }
    
    .file-preview-container {
        background-color: var(--dark-card);
        border-radius: 1rem;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .file-preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid var(--dark-border);
    }

    .file-preview-header h6 {
        margin: 0;
    }

    .file-preview-content {
        padding: 0;
        height: 600px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .pdf-viewer {
        width: 100%;
        height: 100%;
        border: none;
    }

    .doc-preview-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
        height: 100%;
    }

    .doc-icon-container i {
        font-size: 5rem;
    }

    .doc-filename {
        font-weight: bold;
        text-align: center;
    }
    
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    .fade-in-1 { animation-delay: 0.1s; }
    .fade-in-2 { animation-delay: 0.2s; }
    .fade-in-3 { animation-delay: 0.3s; }
    .fade-in-4 { animation-delay: 0.4s; }
    .fade-in-5 { animation-delay: 0.5s; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            $('#deleteForm').attr('action', `{{ url('jadwal') }}/${id}`);
            $('#deleteModal').modal('show');
        });
    });
</script>
@endpush
