@extends('layouts.template')

@section('title', 'Tambah Jadwal - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dasbor</a>
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
                    <h5 class="mb-0">Formulir Tambah Jadwal</h5>
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
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required min="{{ date('Y-m-d') }}">
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
                                <label for="file_info" class="form-control-label">Berkas <span class="text-danger">*</span></label>
                                <div class="document-upload-container">
                                    <div class="document-preview" id="file-preview">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>PDF, DOC, DOCX</span>
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_info" id="file_info"
                                            class="document-upload-input @error('file_info') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx" required tabindex="0">
                                        <label for="file_info" class="btn btn-outline-primary w-100" role="button">
                                            <i class="fas fa-upload me-2"></i>Unggah Berkas
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: PDF, DOC, DOCX. Maks: 2MB</small>
                                @error('file_info')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
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
<style>
    .document-upload-container {
        display: flex;
        gap: 20px;
        margin-bottom: 10px;
    }

    .document-preview {
        width: 150px;
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
        position: relative;
    }

    .document-upload-input:focus + label {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    .document-upload-input:focus-visible + label {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    /* Memperbaiki accessibility */
    .document-upload-input {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .document-upload-button label.error {
        border-color: #dc3545;
    }

    .is-invalid ~ .document-upload-button label {
        border-color: #dc3545;
    }

    .error-message {
        color: #dc3545;
        margin-top: 0.25rem;
        font-size: 0.875em;
    }

    .document-upload-button label.error {
        border-color: #dc3545;
    }

    .invalid-feedback.error-message {
    display: block;
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.5rem;
    font-weight: 500;
    }

    .text-success {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush


@push('js')
<script>
    $(document).ready(function() {
        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        $('#tanggal').val(today);

        // Form validation before submit
        $('#jadwal-form').submit(function(e) {
            const tanggal = $('#tanggal').val();
            const informasi = $('#informasi').val();
            const fileInfo = $('#file_info').val();

            let isValid = true;

            // Reset error messages
            $('.error-message').remove();
            $('.is-invalid').removeClass('is-invalid');

            // Validate tanggal
            if (!tanggal) {
                e.preventDefault();
                $('#tanggal').addClass('is-invalid');
                $('<div class="invalid-feedback error-message">Tanggal harus diisi!</div>').insertAfter('#tanggal');
                isValid = false;
            }

            // Validate informasi
            if (!informasi) {
                e.preventDefault();
                $('#informasi').addClass('is-invalid');
                $('.input-group:has(#informasi)').after('<div class="invalid-feedback error-message d-block">Informasi harus diisi!</div>');
                isValid = false;
            }

            // Validate file
            if (!fileInfo) {
                e.preventDefault();
                $('#file_info').addClass('is-invalid');
                $('.document-upload-button').after('<div class="invalid-feedback error-message d-block">File harus ditambahkan!</div>');
                $('.document-upload-button label').css('border-color', '#dc3545');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = $('.error-message').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                }
            }

            return isValid;
        });

        // Remove error when input changes
        $('input').on('change', function() {
            $(this).removeClass('is-invalid');
            $(this).closest('.form-group').find('.error-message').remove();
            if ($(this).attr('id') === 'file_info') {
                $('.document-upload-button label').css('border-color', '');
            }
        });

        // Tambahkan handler untuk keyboard accessibility
        $('.document-upload-button label').on('keypress', function(e) {
            if (e.which === 13 || e.which === 32) { // Enter atau Space
                e.preventDefault();
                $('#file_info').click();
            }
        });

        // Perbaikan untuk file input focus
        $('#file_info').on('focus', function() {
            $(this).next('label').addClass('focused');
        }).on('blur', function() {
            $(this).next('label').removeClass('focused');
        });


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

                // Remove error message if exists
                $('.error-message').remove();
                $('#file_info').removeClass('is-invalid');
                $('.document-upload-button label').css('border-color', '');
            }
        });
        // Tambahkan ini di bagian akhir script
        $('#file_info').on('change', function() {
            const file = this.files[0];
            const fileSize = file ? file.size / 1024 / 1024 : 0; // Convert to MB
            const allowedExtensions = ['pdf', 'doc', 'docx'];
            const fileExtension = file ? file.name.split('.').pop().toLowerCase() : '';

            // Reset error styling
            $(this).removeClass('is-invalid');
            $('.error-message').remove();

            if (file) {
                // Validate file size
                if (fileSize > 2) {
                    $(this).addClass('is-invalid');
                    $('.document-upload-button').after(`
                        <div class="invalid-feedback error-message d-block">
                            Ukuran file tidak boleh lebih dari 2MB! File anda: ${fileSize.toFixed(2)}MB
                        </div>
                    `);
                    this.value = ''; // Clear file input
                    return;
                }

                // Validate file extension
                if (!allowedExtensions.includes(fileExtension)) {
                    $(this).addClass('is-invalid');
                    $('.document-upload-button').after(`
                        <div class="invalid-feedback error-message d-block">
                            Format file harus PDF, DOC, atau DOCX!
                        </div>
                    `);
                    this.value = ''; // Clear file input
                    return;
                }

                // Show success message
                $('.document-upload-button').after(`
                    <div class="text-success mt-2">
                        <i class="fas fa-check-circle"></i> File valid dan siap diupload
                    </div>
                `);
            }
        });
    });
</script>
@endpush
