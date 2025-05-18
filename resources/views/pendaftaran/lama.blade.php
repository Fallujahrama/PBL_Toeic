@extends('layouts.template')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/') }}">Home</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('pendaftaran.index') }}">Pendaftaran</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Mahasiswa Lama</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $page->title ?? 'Form Pendaftaran Mahasiswa Lama' }}</h6>
</div>

<div class="card animate-card" data-aos="fade-up">
    <div class="card-header pb-0">
        <div class="d-flex align-items-center">
            <div class="icon icon-shape icon-sm bg-gradient-warning text-white rounded-circle shadow me-2">
                <i class="fas fa-user-edit"></i>
            </div>
            <h5 class="mb-0">Second Registration Form</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6 mx-auto" data-aos="fade-up" data-aos-delay="100">
                <div class="card p-3" style="background-color: var(--dark-hover); border: 1px solid var(--dark-border);">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="fas fa-search me-2"></i>Find Student Data</h6>
                        <div class="input-group">
                            <input type="text" id="search-nim" class="form-control" placeholder="Enter NIM">
                            <button class="btn btn-primary" type="button" id="search-button">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        <div id="search-result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="registration-form" style="display: none;">
            <form action="{{ route('pendaftaran.lama.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="nim" id="nim-input">
                
                <div class="row">
                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                        <div class="info-card">
                            <div class="card-header">
                                <h6>Student Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="profile-info-item fade-in fade-in-1">
                                    <div class="profile-info-label">
                                        <i class="fas fa-id-card me-2"></i>NIM
                                    </div>
                                    <div class="profile-info-value" id="display-nim">
                                        -
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-2">
                                    <div class="profile-info-label">
                                        <i class="fas fa-user me-2"></i>Name
                                    </div>
                                    <div class="profile-info-value" id="display-name">
                                        -
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-3">
                                    <div class="profile-info-label">
                                        <i class="fas fa-graduation-cap me-2"></i>Program
                                    </div>
                                    <div class="profile-info-value" id="display-program">
                                        -
                                    </div>
                                </div>
                                <div class="profile-info-item fade-in fade-in-4">
                                    <div class="profile-info-label">
                                        <i class="fas fa-university me-2"></i>Campus
                                    </div>
                                    <div class="profile-info-value" id="display-campus">
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="300">
                        <div class="form-group">
                            <label for="bukti_pembayaran" class="form-control-label">Payment Proof (Required)</label>
                            <div class="document-upload-container">
                                <div class="document-preview" id="payment-preview">
                                    <i class="fas fa-receipt"></i>
                                    <span>Payment Proof</span>
                                </div>
                                <div class="document-upload-button">
                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="document-upload-input @error('bukti_pembayaran') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                    <label for="bukti_pembayaran" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-upload me-2"></i>Upload Payment Proof
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted">Format: JPG, PNG, PDF. Max: 10MB</small>
                            @error('bukti_pembayaran')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12" data-aos="fade-up" data-aos-delay="400">
                        <div class="card p-3" style="background-color: var(--dark-hover); border: 1px solid var(--dark-border);">
                            <div class="card-body">
                                <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Additional Documents (Optional)</h6>
                                <p class="text-muted mb-4">If you need to update your documents, you can upload them below. Leave empty if you don't want to update.</p>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="file_ktp" class="form-control-label">KTP</label>
                                            <div class="document-upload-container">
                                                <div class="document-preview" id="ktp-preview">
                                                    <i class="fas fa-id-card"></i>
                                                    <span>KTP (Optional)</span>
                                                </div>
                                                <div class="document-upload-button">
                                                    <input type="file" name="file_ktp" id="file_ktp" class="document-upload-input @error('file_ktp') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                                    <label for="file_ktp" class="btn btn-outline-secondary w-100">
                                                        <i class="fas fa-upload me-2"></i>Update KTP
                                                    </label>
                                                </div>
                                            </div>
                                            @error('file_ktp')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="file_ktm" class="form-control-label">KTM</label>
                                            <div class="document-upload-container">
                                                <div class="document-preview" id="ktm-preview">
                                                    <i class="fas fa-address-card"></i>
                                                    <span>KTM (Optional)</span>
                                                </div>
                                                <div class="document-upload-button">
                                                    <input type="file" name="file_ktm" id="file_ktm" class="document-upload-input @error('file_ktm') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                                    <label for="file_ktm" class="btn btn-outline-secondary w-100">
                                                        <i class="fas fa-upload me-2"></i>Update KTM
                                                    </label>
                                                </div>
                                            </div>
                                            @error('file_ktm')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="file_foto" class="form-control-label">Photo</label>
                                            <div class="document-upload-container">
                                                <div class="document-preview" id="foto-preview">
                                                    <i class="fas fa-user"></i>
                                                    <span>Photo (Optional)</span>
                                                </div>
                                                <div class="document-upload-button">
                                                    <input type="file" name="file_foto" id="file_foto" class="document-upload-input @error('file_foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                                                    <label for="file_foto" class="btn btn-outline-secondary w-100">
                                                        <i class="fas fa-upload me-2"></i>Update Photo
                                                    </label>
                                                </div>
                                            </div>
                                            @error('file_foto')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="500">
                    <a href="{{ url('pendaftaran') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Submit Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
<link href="{{ asset('css/jadwal.css') }}" rel="stylesheet">
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Search for student by NIM
        $('#search-button').click(function() {
            const nim = $('#search-nim').val().trim();
            if (!nim) {
                $('#search-result').html('<div class="alert alert-warning mt-2">Please enter a valid NIM</div>');
                return;
            }
            
            $('#search-result').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Searching...</div>');
            
            // AJAX request to get student data
            $.ajax({
                url: `/pendaftaran/lama/get-mahasiswa/${nim}`,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        // Display student data
                        const student = response.data;
                        $('#search-result').html('<div class="alert alert-success mt-2">Student found! You can now complete the registration.</div>');
                        
                        // Fill the form with student data
                        $('#nim-input').val(student.nim);
                        $('#display-nim').text(student.nim);
                        $('#display-name').text(student.nama);
                        $('#display-program').text(student.program_studi || student.prodi || '-');
                        $('#display-campus').text(student.kampus || '-');
                        
                        // Show the registration form
                        $('#registration-form').slideDown();
                    } else {
                        $('#search-result').html('<div class="alert alert-danger mt-2">Student not found. Please check the NIM or register as a new student.</div>');
                        $('#registration-form').slideUp();
                    }
                },
                error: function() {
                    $('#search-result').html('<div class="alert alert-danger mt-2">Error connecting to server. Please try again.</div>');
                }
            });
        });
        
        // Preview for payment proof
        $('#bukti_pembayaran').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type === 'application/pdf') {
                        $('#payment-preview').html(`
                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>
                            <span>${file.name}</span>
                        `);
                    } else {
                        $('#payment-preview').html(`<img src="${e.target.result}" alt="Payment Preview">`);
                    }
                    $('#payment-preview').addClass('has-preview');
                }
                reader.readAsDataURL(file);
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File selected');
            }
        });
        
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
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File selected');
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
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File selected');
            }
        });
        
        // Preview for Photo
        $('#file_foto').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#foto-preview').html(`<img src="${e.target.result}" alt="Photo Preview">`);
                    $('#foto-preview').addClass('has-preview');
                }
                reader.readAsDataURL(file);
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File selected');
            }
        });
    });
</script>
@endpush

@endsection
