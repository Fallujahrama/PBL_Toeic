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
                <!-- Alert for displaying messages -->
                <div id="alert-container"></div>
                
                <form id="pendaftaran-form" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                            <div class="form-group">
                                <label for="nim" class="form-control-label">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <select name="nim" id="nim" class="form-control">
                                        <option value="">-- Pilih NIM Mahasiswa --</option>
                                        @foreach($mahasiswa as $mhs)
                                            <option value="{{ $mhs->nim }}">{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="text-danger error-text nim_error"></small>
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
                                        <input type="file" name="file_ktp" id="file_ktp" class="document-upload-input" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                        <label for="file_ktp" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Upload KTP
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                                <small class="text-danger error-text file_ktp_error"></small>
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
                                        <input type="file" name="file_ktm" id="file_ktm" class="document-upload-input" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                        <label for="file_ktm" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Upload KTM
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                                <small class="text-danger error-text file_ktm_error"></small>
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
                                        <input type="file" name="file_foto" id="file_foto" class="document-upload-input" accept="image/jpeg,image/png,image/jpg">
                                        <label for="file_foto" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Upload Foto
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                                <small class="text-danger error-text file_foto_error"></small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" id="submit-btn">
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
        
        // Form submission with AJAX
        $('#pendaftaran-form').on('submit', function(e) {
            e.preventDefault();
            
            // Reset error messages
            $('.error-text').text('');
            
            // Create FormData object for file uploads
            let formData = new FormData(this);
            
            // Show loading state
            $('#submit-btn').html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
            $('#submit-btn').prop('disabled', true);
            
            $.ajax({
                url: "{{ route('pendaftaran.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.status) {
                        // Show success message
                        $('#alert-container').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="d-flex">
                                    <div class="icon icon-shape icon-xs bg-gradient-success text-white rounded-circle shadow me-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span>${response.message}</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        
                        // Reset form
                        $('#pendaftaran-form')[0].reset();
                        $('.document-preview').removeClass('has-preview');
                        $('#ktp-preview').html(`<i class="fas fa-id-card"></i><span>KTP</span>`);
                        $('#ktm-preview').html(`<i class="fas fa-address-card"></i><span>KTM</span>`);
                        $('#foto-preview').html(`<i class="fas fa-user"></i><span>Foto</span>`);
                        $('label[for="file_ktp"]').html('<i class="fas fa-upload me-2"></i>Upload KTP');
                        $('label[for="file_ktm"]').html('<i class="fas fa-upload me-2"></i>Upload KTM');
                        $('label[for="file_foto"]').html('<i class="fas fa-upload me-2"></i>Upload Foto');
                        
                        // Scroll to top to see the message
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        
                        // Redirect after 2 seconds
                        setTimeout(function() {
                            window.location.href = "{{ route('pendaftaran.index') }}";
                        }, 2000);
                    } else {
                        // Show error message
                        $('#alert-container').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex">
                                    <div class="icon icon-shape icon-xs bg-gradient-danger text-white rounded-circle shadow me-2">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <span>${response.message}</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        
                        // Display validation errors
                        if(response.errors) {
                            $.each(response.errors, function(prefix, val) {
                                $('.'+prefix+'_error').text(val[0]);
                            });
                        }
                        
                        // Scroll to top to see the message
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                    }
                    
                    // Reset button state
                    $('#submit-btn').html('<i class="fas fa-save me-2"></i>Simpan');
                    $('#submit-btn').prop('disabled', false);
                },
                error: function(xhr) {
                    // Show error message
                    $('#alert-container').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex">
                                <div class="icon icon-shape icon-xs bg-gradient-danger text-white rounded-circle shadow me-2">
                                    <i class="fas fa-times"></i>
                                </div>
                                <span>Terjadi kesalahan. Silakan coba lagi.</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                    
                    // Display validation errors if any
                    if(xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(prefix, val) {
                            $('.'+prefix+'_error').text(val[0]);
                        });
                    }
                    
                    // Scroll to top to see the message
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    
                    // Reset button state
                    $('#submit-btn').html('<i class="fas fa-save me-2"></i>Simpan');
                    $('#submit-btn').prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush
