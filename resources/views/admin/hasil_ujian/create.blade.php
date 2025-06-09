@extends('layouts.template')

@section('title', 'Upload Hasil Ujian - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dasbor</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('hasil_ujian.index') }}">Hasil Ujian</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Unggah</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Unggah Hasil Ujian</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-success text-white rounded-circle shadow me-2">
                        <i class="fas fa-upload"></i>
                    </div>
                    <h5 class="mb-0">Formulir Upload Hasil Ujian</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('hasil_ujian.store') }}" method="POST" enctype="multipart/form-data" id="hasil-ujian-form">
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
                                <label for="jadwal_id" class="form-control-label">Jadwal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                    <select name="jadwal_id" id="jadwal_id" class="form-control @error('jadwal_id') is-invalid @enderror" required>
                                        <option value="">Pilih Jadwal</option>
                                        @foreach ($jadwal as $item)
                                            <option value="{{ $item->jadwal_id }}">{{ $item->informasi }} ({{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('jadwal_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12" data-aos="fade-up" data-aos-delay="300">
                            <div class="form-group">
                                <label for="file_nilai" class="form-control-label">Berkas Hasil Ujian</label>
                                <div class="document-upload-container">
                                    <div class="document-preview" id="file-preview">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>PDF, DOC, DOCX, XLSX</span>
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_nilai" id="file_nilai" class="document-upload-input @error('file_nilai') is-invalid @enderror" accept=".pdf,.doc,.docx,.xlsx" required>
                                        <label for="file_nilai" class="btn btn-outline-success w-100">
                                            <i class="fas fa-upload me-2"></i>Upload Berkas
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: PDF, DOC, DOCX, XLSX. Maks: 2MB</small>
                                @error('file_nilai')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="400">
                        <a href="{{ route('hasil_ujian.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .document-upload-container {
        display: flex;
        gap: 20px;
        margin-bottom: 10px;
    }

    .document-preview {
        width: 120px;
        height: 150px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .document-preview.has-preview {
        border: none;
        background-color: transparent;
    }

    .document-preview i {
        font-size: 2rem;
        color: #adb5bd;
        margin-bottom: 10px;
    }

    .document-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .document-upload-button {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .document-upload-input {
        display: none;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        $('#tanggal').val(today);

        // Preview for file
        $('#file_nilai').change(function() {
            const file = this.files[0];
            if (file) {
                const allowed = ['pdf', 'doc', 'docx', 'xlsx'];
                const ext = file.name.split('.').pop().toLowerCase();
                if (!allowed.includes(ext)) {
                    alert('Format file tidak diizinkan! Hanya PDF, DOC, DOCX, XLSX.');
                    $(this).val(''); // reset input
                    $('#file-preview').html(`
                        <i class="fas fa-file-pdf"></i>
                        <span>PDF, DOC, DOCX, XLSX</span>
                    `);
                    $('#file-preview').removeClass('has-preview');
                    $(this).next('label').html('<i class="fas fa-upload me-2"></i>Upload File');
                    return;
                }
                let icon = '<i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>';
                if (ext === 'doc' || ext === 'docx') {
                    icon = '<i class="fas fa-file-word" style="font-size: 3rem; color: #3b82f6;"></i>';
                } else if (ext === 'xlsx') {
                    icon = '<i class="fas fa-file-excel" style="font-size: 3rem; color: #10b981;"></i>';
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
