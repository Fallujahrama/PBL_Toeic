@extends('layouts.template')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('mahasiswa.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('pendaftaran.index') }}">Pendaftaran</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Mahasiswa Baru</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Form Pendaftaran Mahasiswa Baru</h6>
</div>

<div class="card animate-card" data-aos="fade-up">
    <div class="card-header pb-0">
        <div class="d-flex align-items-center">
            <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                <i class="fas fa-user-plus"></i>
            </div>
            <h5 class="mb-0">First Registration Form</h5>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(isset($draftData) && $draftData)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>Draft data found and loaded automatically.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{ route('pendaftaran.storeBaru') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
            @csrf
    
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="form-group">
                        <label for="nama" class="form-control-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $draftData->nama ?? '') }}" required>
                        </div>
                        @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
                    <div class="form-group">
                        <label for="nim" class="form-control-label">NIM</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ auth()->user()->username ?? old('nim') }}" required>
                        </div>
                        @error('nim')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                    <div class="form-group">
                        <label for="nik" class="form-control-label">NIK</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $draftData->nik ?? '') }}" required>
                        </div>
                        @error('nik')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="form-group">
                        <label for="wa" class="form-control-label">No. WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                            <span class="input-group-text bg-light">+62</span>
                            <input type="text" name="wa" id="wa" class="form-control @error('wa') is-invalid @enderror" value="{{ old('wa', $draftData->wa ?? '') }}" placeholder="8123456789" required>
                        </div>
                        <small class="text-muted">Contoh: 8123456789 (tanpa +62)</small>
                        @error('wa')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="300">
                    <div class="form-group">
                        <label for="alamat_asal" class="form-control-label">Alamat Asal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                            <textarea name="alamat_asal" id="alamat_asal" class="form-control @error('alamat_asal') is-invalid @enderror" rows="3" required>{{ old('alamat_asal', $draftData->alamat_asal ?? '') }}</textarea>
                        </div>
                        @error('alamat_asal')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="form-group">
                        <label for="alamat_sekarang" class="form-control-label">Alamat Sekarang</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <textarea name="alamat_sekarang" id="alamat_sekarang" class="form-control @error('alamat_sekarang') is-invalid @enderror" rows="3" required>{{ old('alamat_sekarang', $draftData->alamat_sekarang ?? '') }}</textarea>
                        </div>
                        @error('alamat_sekarang')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="form-group">
                        <label for="prodi" class="form-control-label">Program Studi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                            <input type="text" name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror" value="{{ old('prodi', $draftData->prodi ?? '') }}" required>
                        </div>
                        @error('prodi')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="form-group">
                        <label for="jurusan" class="form-control-label">Jurusan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <select name="jurusan" id="jurusan" class="form-control @error('jurusan') is-invalid @enderror" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="Akuntansi" {{ old('jurusan', $draftData->jurusan ?? '') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                <option value="Administrasi Niaga" {{ old('jurusan', $draftData->jurusan ?? '') == 'Administrasi Niaga' ? 'selected' : '' }}>Administrasi Niaga</option>
                                <option value="Teknik Elektro" {{ old('jurusan', $draftData->jurusan ?? '') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                                <option value="Teknik Mesin" {{ old('jurusan', $draftData->jurusan ?? '') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                <option value="Teknik Kimia" {{ old('jurusan', $draftData->jurusan ?? '') == 'Teknik Kimia' ? 'selected' : '' }}>Teknik Kimia</option>
                                <option value="Teknik Sipil" {{ old('jurusan', $draftData->jurusan ?? '') == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                                <option value="Teknologi Informasi" {{ old('jurusan', $draftData->jurusan ?? '') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                            </select>
                        </div>
                        @error('jurusan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="form-group">
                        <label for="kampus" class="form-control-label">Kampus</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-university"></i></span>
                            <select name="kampus" id="kampus" class="form-control @error('kampus') is-invalid @enderror" required>
                                <option value="">-- Pilih Kampus --</option>
                                <option value="Utama" {{ old('kampus', $draftData->kampus ?? '') == 'Utama' ? 'selected' : '' }}>Utama</option>
                                <option value="PSDKU Kediri" {{ old('kampus', $draftData->kampus ?? '') == 'PSDKU Kediri' ? 'selected' : '' }}>PSDKU Kediri</option>
                                <option value="PSDKU Lumajang" {{ old('kampus', $draftData->kampus ?? '') == 'PSDKU Lumajang' ? 'selected' : '' }}>PSDKU Lumajang</option>
                                <option value="PSDKU Pamekasan" {{ old('kampus', $draftData->kampus ?? '') == 'PSDKU Pamekasan' ? 'selected' : '' }}>PSDKU Pamekasan</option>
                            </select>
                        </div>
                        @error('kampus')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="text-primary mb-3"><i class="fas fa-file-upload me-2"></i>Upload Required Documents</h6>
                </div>
            </div>

            <div class="row">
                {{-- Scan KTP --}}
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
                    <div class="form-group border rounded p-3 shadow-sm">
                        <label for="ktp" class="form-control-label fw-semibold">Scan KTP (Required)</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="ktp-preview">
                                <i class="fas fa-id-card"></i>
                                <span>KTP</span>
                            </div>
                            <div class="document-upload-button mt-2">
                                <input type="file" name="ktp" id="ktp" class="document-upload-input @error('ktp') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                <label for="ktp" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-upload me-2"></i>Upload KTP
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max: 10MB</small>
                        @error('ktp')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Scan KTM --}}
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="300">
                    <div class="form-group border rounded p-3 shadow-sm">
                        <label for="scan_ktm" class="form-control-label fw-semibold">Scan KTM (Required)</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="ktm-preview">
                                <i class="fas fa-address-card"></i>
                                <span>KTM</span>
                            </div>
                            <div class="document-upload-button mt-2">
                                <input type="file" name="scan_ktm" id="scan_ktm" class="document-upload-input @error('scan_ktm') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                <label for="scan_ktm" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-upload me-2"></i>Upload KTM
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max: 10MB</small>
                        @error('scan_ktm')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Pas Foto --}}
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="400">
                    <div class="form-group border rounded p-3 shadow-sm">
                        <label for="pas_foto" class="form-control-label fw-semibold">Pas Foto Terbaru (Required)</label>
                        <div class="document-upload-container">
                            <div class="document-preview photo-preview" id="foto-preview">
                                <i class="fas fa-user"></i>
                                <span>Foto</span>
                            </div>
                            <div class="document-upload-button mt-2">
                                <input type="file" name="pas_foto" id="pas_foto" class="document-upload-input @error('pas_foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" required>
                                <label for="pas_foto" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-upload me-2"></i>Upload Foto
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                        @error('pas_foto')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4" data-aos="fade-up" data-aos-delay="800">
                <div>
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-primary me-2" id="saveDraftBtn">
                        <span class="btn-text">
                            <i class="fas fa-save me-2"></i>Save Draft
                        </span>
                        <span class="btn-loading d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>Saving...
                        </span>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="btn-text">
                            <i class="fas fa-paper-plane me-2"></i>Submit Registration
                        </span>
                        <span class="btn-loading d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>Processing...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    // Load draft data on page load
    loadDraftData();
    
    // Save draft functionality
    $('#saveDraftBtn').on('click', function(e) {
        e.preventDefault();
        saveDraft();
    });
    
    // Auto-save every 2 minutes
    setInterval(function() {
        if (hasFormData()) {
            saveDraft(true); // Silent save
        }
    }, 120000); // 2 minutes
    
    // Form submission handling
    $('#registrationForm').on('submit', function(e) {
        console.log('Form submission started');
        
        // Show loading state
        const submitBtn = $('#submitBtn');
        const btnText = submitBtn.find('.btn-text');
        const btnLoading = submitBtn.find('.btn-loading');
        
        submitBtn.prop('disabled', true);
        btnText.addClass('d-none');
        btnLoading.removeClass('d-none');
        
        // Basic validation
        let isValid = true;
        const requiredFields = ['nama', 'nik', 'wa', 'alamat_asal', 'alamat_sekarang', 'prodi', 'jurusan', 'kampus'];
        
        requiredFields.forEach(function(field) {
            const input = $(`[name="${field}"]`);
            if (!input.val().trim()) {
                isValid = false;
                input.addClass('is-invalid');
                console.log(`Field ${field} is empty`);
            } else {
                input.removeClass('is-invalid');
            }
        });
        
        // File validation
        const requiredFiles = ['ktp', 'scan_ktm', 'pas_foto'];
        requiredFiles.forEach(function(field) {
            const input = $(`[name="${field}"]`);
            if (!input[0].files.length) {
                isValid = false;
                input.addClass('is-invalid');
                console.log(`File ${field} is not selected`);
            } else {
                input.removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            
            // Reset button state
            submitBtn.prop('disabled', false);
            btnText.removeClass('d-none');
            btnLoading.addClass('d-none');
            
            // Show error message
            showAlert('Please fill all required fields and upload all required documents.', 'danger');
            console.log('Form validation failed');
            return false;
        }
        
        console.log('Form validation passed, submitting...');
    });
    
    // Preview for KTP
    $('#ktp').change(function() {
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
            $(this).next('label').html('<i class="fas fa-check me-2"></i>File Selected');
        }
    });

    // Preview for KTM
    $('#scan_ktm').change(function() {
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
            $(this).next('label').html('<i class="fas fa-check me-2"></i>File Selected');
        }
    });

    // Preview for Foto with circular styling
    $('#pas_foto').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#foto-preview').html(`<img src="${e.target.result}" alt="Foto Preview" class="rounded-circle">`);
                $('#foto-preview').addClass('has-preview');
            }
            reader.readAsDataURL(file);
            $(this).next('label').html('<i class="fas fa-check me-2"></i>File Selected');
        }
    });

    // Click on preview to trigger file input
    $('.document-preview').click(function() {
        const container = $(this).closest('.form-group');
        const input = container.find('input[type="file"]');
        input.click();
    });

    // WhatsApp number formatting
    $('#wa').on('input', function() {
        let value = $(this).val();
        // Remove any non-digit characters
        value = value.replace(/\D/g, '');
        // Remove leading 62 if user types it
        if (value.startsWith('62')) {
            value = value.substring(2);
        }
        // Remove leading 0 if user types it
        if (value.startsWith('0')) {
            value = value.substring(1);
        }
        // Limit to reasonable length (max 13 digits after +62)
        if (value.length > 13) {
            value = value.substring(0, 13);
        }
        $(this).val(value);
    });

    // Format display on blur
    $('#wa').on('blur', function() {
        let value = $(this).val();
        if (value && !value.startsWith('8')) {
            // If doesn't start with 8, add it
            if (value.length > 0) {
                $(this).val('8' + value);
            }
        }
    });
});

// Load draft data function - updated to be silent
function loadDraftData() {
    $.ajax({
        url: '{{ route("pendaftaran.loadDraft") }}',
        type: 'GET',
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                // Fill form fields with draft data
                $('[name="nama"]').val(data.nama || '');
                $('[name="nik"]').val(data.nik || '');
                $('[name="wa"]').val(data.wa || '');
                $('[name="alamat_asal"]').val(data.alamat_asal || '');
                $('[name="alamat_sekarang"]').val(data.alamat_sekarang || '');
                $('[name="prodi"]').val(data.prodi || '');
                $('[name="jurusan"]').val(data.jurusan || '');
                $('[name="kampus"]').val(data.kampus || '');
                
                // Don't show alert for automatic loading
                // Only show alert when user manually saves draft
            }
        },
        error: function() {
            // Silent fail - no draft exists
        }
    });
}

// Save draft function
function saveDraft(silent = false) {
    const saveDraftBtn = $('#saveDraftBtn');
    const btnText = saveDraftBtn.find('.btn-text');
    const btnLoading = saveDraftBtn.find('.btn-loading');
    
    if (!silent) {
        saveDraftBtn.prop('disabled', true);
        btnText.addClass('d-none');
        btnLoading.removeClass('d-none');
    }
    
    const formData = {
        nama: $('[name="nama"]').val(),
        nik: $('[name="nik"]').val(),
        wa: $('[name="wa"]').val(),
        alamat_asal: $('[name="alamat_asal"]').val(),
        alamat_sekarang: $('[name="alamat_sekarang"]').val(),
        prodi: $('[name="prodi"]').val(),
        jurusan: $('[name="jurusan"]').val(),
        kampus: $('[name="kampus"]').val(),
        _token: $('[name="_token"]').val()
    };
    
    $.ajax({
        url: '{{ route("pendaftaran.saveDraft") }}',
        type: 'POST',
        data: formData,
        success: function(response) {
            if (!silent) {
                if (response.status === 'success') {
                    showAlert(response.message, 'success');
                } else {
                    showAlert(response.message, 'danger');
                }
            }
        },
        error: function() {
            if (!silent) {
                showAlert('Failed to save draft. Please try again.', 'danger');
            }
        },
        complete: function() {
            if (!silent) {
                saveDraftBtn.prop('disabled', false);
                btnText.removeClass('d-none');
                btnLoading.addClass('d-none');
            }
        }
    });
}

// Check if form has data
function hasFormData() {
    const fields = ['nama', 'nik', 'wa', 'alamat_asal', 'alamat_sekarang', 'prodi', 'jurusan', 'kampus'];
    return fields.some(field => $(`[name="${field}"]`).val().trim() !== '');
}

// Helper function to show alerts - updated to avoid sidebar
function showAlert(message, type = 'danger') {
    // Remove any existing alerts first
    $('.main-content .alert').remove();
    
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'info' ? 'info-circle' : 'exclamation-circle'} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Insert alert specifically in the card body, not anywhere else
    $('.card-body').first().prepend(alertHtml);
    
    // Auto remove after 5 seconds
    setTimeout(function() {
        $('.card-body .alert').fadeOut();
    }, 5000);
}
</script>
@endpush
