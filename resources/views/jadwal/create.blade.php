@extends('layouts.template')

@section('title', 'Tambah Jadwal - TOEIC Center')

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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Tambah Jadwal</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h5 class="mb-0">Form Tambah Jadwal</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data" id="jadwal-form">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                            <div class="form-group">
                                <label for="tanggal" class="form-control-label">Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                                </div>
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                            <div class="form-group">
                                <label for="informasi" class="form-control-label">Informasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <input type="text" name="informasi" id="informasi" class="form-control @error('informasi') is-invalid @enderror" value="{{ old('informasi') }}" required>
                                </div>
                                @error('informasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12" data-aos="fade-up" data-aos-delay="300">
                            <div class="form-group">
                                <label for="file_info" class="form-control-label">File (Opsional)</label>
                                <div class="document-upload-container">
                                    <div class="document-preview" id="file-preview">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>PDF, DOC, DOCX</span>
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_info" id="file_info" class="document-upload-input @error('file_info') is-invalid @enderror" accept=".pdf,.doc,.docx">
                                        <label for="file_info" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Upload File
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: PDF, DOC, DOCX. Maks: 2MB</small>
                                @error('file_info')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="400">
                        <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('css/jadwal.css') }}" rel="stylesheet">
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        $('#tanggal').val(today);
        
        // Preview for file
        $('#file_info').change(function() {
            const file = this.files[0];
            if (file) {
                let icon = '<i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>';
                
                if (file.name.endsWith('.doc') || file.name.endsWith('.docx')) {
                    icon = '<i class="fas fa-file-word" style="font-size: 3rem; color: #3b82f6;"></i>';
                }
                
                $('#file-preview').html(`
                    ${icon}
                    <span>${file.name}</span>
                `);
                $('#file-preview').addClass('has-preview');
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File dipilih');
            }
        });
    });
</script>
@endpush
