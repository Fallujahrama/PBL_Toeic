@extends('layouts.template')

@section('title', 'Tambah Pendaftaran - TOEIC Center')

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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Tambah Pendaftaran</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h5 class="mb-0">Form Pendaftaran TOEIC</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" id="pendaftaran-form">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                            <div class="form-group">
                                <label for="nim" class="form-control-label">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" required>
                                </div>
                                @error('nim')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="form-group">
                                <label for="file_ktp" class="form-control-label">File KTP</label>
                                <div class="document-upload-container">
                                    <div class="document-preview" id="ktp-preview">
                                        <i class="fas fa-id-card"></i>
                                        <span>KTP</span>
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_ktp" id="file_ktp" class="document-upload-input @error('file_ktp') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                        <label for="file_ktp" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Upload KTP
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                                @error('file_ktp')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="form-group">
                                <label for="file_ktm" class="form-control-label">File KTM</label>
                                <div class="document-upload-container">
                                    <div class="document-preview" id="ktm-preview">
                                        <i class="fas fa-address-card"></i>
                                        <span>KTM</span>
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_ktm" id="file_ktm" class="document-upload-input @error('file_ktm') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                        <label for="file_ktm" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Upload KTM
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                                @error('file_ktm')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="form-group">
                                <label for="file_foto" class="form-control-label">Pas Foto</label>
                                <div class="document-upload-container">
                                    <div class="document-preview" id="foto-preview">
                                        <i class="fas fa-user"></i>
                                        <span>Foto</span>
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_foto" id="file_foto" class="document-upload-input @error('file_foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" required>
                                        <label for="file_foto" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Upload Foto
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                                @error('file_foto')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary me-2">
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

@push('js')
<script>
    $(document).ready(function() {
        // Preview for KTP
        $('#file_ktp').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type === 'application/pdf') {
                        $('#ktp-preview').html(`
                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>
                            <span>${file.name}</span>
                        `);
                    } else {
                        $('#ktp-preview').html(`<img src="${e.target.result}" alt="KTP Preview">`);
                    }
                    $('#ktp-preview').addClass('has-preview');
                }
                reader.readAsDataURL(file);
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File dipilih');
            }
        });
        
        // Preview for KTM
        $('#file_ktm').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type === 'application/pdf') {
                        $('#ktm-preview').html(`
                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>
                            <span>${file.name}</span>
                        `);
                    } else {
                        $('#ktm-preview').html(`<img src="${e.target.result}" alt="KTM Preview">`);
                    }
                    $('#ktm-preview').addClass('has-preview');
                }
                reader.readAsDataURL(file);
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File dipilih');
            }
        });
        
        // Preview for Foto
        $('#file_foto').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#foto-preview').html(`<img src="${e.target.result}" alt="Foto Preview">`);
                    $('#foto-preview').addClass('has-preview');
                }
                reader.readAsDataURL(file);
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File dipilih');
            }
        });
    });
</script>
@endpush
