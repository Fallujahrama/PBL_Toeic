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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Data</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Edit Data Mahasiswa</h6>
</div>

<div class="card animate-card" data-aos="fade-up">
    <div class="card-header pb-0">
        <div class="d-flex align-items-center">
            <div class="icon icon-shape icon-sm bg-gradient-warning text-white rounded-circle shadow me-2">
                <i class="fas fa-user-edit"></i>
            </div>
            <h5 class="mb-0">Edit Registration Form</h5>
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

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian!</strong> Anda hanya dapat mengedit data pendaftaran satu kali. Pastikan data yang Anda masukkan sudah benar.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @php
            // Check if this is a second registration (more than one registration exists)
            $nim = auth()->user()->username;
            $registrationCount = App\Models\PendaftaranModel::where('nim', $nim)->count();
            $isSecondRegistration = $registrationCount > 1;
        @endphp

        <form id="editForm" action="{{ route('mahasiswa.data.update', $mahasiswa->nim) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="form-group">
                        <label for="nama" class="form-control-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mahasiswa->nama ?? '') }}" required>
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
                            <input type="text" name="nim" id="nim" class="form-control" value="{{ $mahasiswa->nim ?? '' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                    <div class="form-group">
                        <label for="nik" class="form-control-label">NIK</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $mahasiswa->nik ?? '') }}" required>
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
                            <input type="text" name="wa" id="wa" class="form-control @error('wa') is-invalid @enderror" value="{{ old('wa', str_replace('+62', '', $mahasiswa->no_whatsapp ?? '')) }}" placeholder="8123456789" required>
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
                            <textarea name="alamat_asal" id="alamat_asal" class="form-control @error('alamat_asal') is-invalid @enderror" rows="3" required>{{ old('alamat_asal', $mahasiswa->alamat_asal ?? '') }}</textarea>
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
                            <textarea name="alamat_sekarang" id="alamat_sekarang" class="form-control @error('alamat_sekarang') is-invalid @enderror" rows="3" required>{{ old('alamat_sekarang', $mahasiswa->alamat_saat_ini ?? '') }}</textarea>
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
                            <input type="text" name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror" value="{{ old('prodi', $mahasiswa->program_studi ?? '') }}" required>
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
                                <option value="Akuntansi" {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                <option value="Administrasi Niaga" {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Administrasi Niaga' ? 'selected' : '' }}>Administrasi Niaga</option>
                                <option value="Teknik Elektro" {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                                <option value="Teknik Mesin" {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                <option value="Teknik Kimia" {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Kimia' ? 'selected' : '' }}>Teknik Kimia</option>
                                <option value="Teknik Sipil" {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                                <option value="Teknologi Informasi" {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
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
                                <option value="Utama" {{ old('kampus', $mahasiswa->kampus ?? '') == 'Utama' ? 'selected' : '' }}>Utama</option>
                                <option value="PSDKU Kediri" {{ old('kampus', $mahasiswa->kampus ?? '') == 'PSDKU Kediri' ? 'selected' : '' }}>PSDKU Kediri</option>
                                <option value="PSDKU Lumajang" {{ old('kampus', $mahasiswa->kampus ?? '') == 'PSDKU Lumajang' ? 'selected' : '' }}>PSDKU Lumajang</option>
                                <option value="PSDKU Pamekasan" {{ old('kampus', $mahasiswa->kampus ?? '') == 'PSDKU Pamekasan' ? 'selected' : '' }}>PSDKU Pamekasan</option>
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
                    <h6 class="text-primary mb-3"><i class="fas fa-file-upload me-2"></i>Update Documents (Optional)</h6>
                </div>
            </div>

            <div class="row">
                {{-- Scan KTP --}}
                <div class="col-md-{{ $isSecondRegistration ? '3' : '4' }}" data-aos="fade-left" data-aos-delay="200">
                    <div class="form-group border rounded p-3 shadow-sm">
                        <label for="file_ktp" class="form-control-label fw-semibold">Scan KTP</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="ktp-preview">
                                @if(isset($pendaftaran) && $pendaftaran->file_ktp)
                                    <img src="{{ asset('storage/'.$pendaftaran->file_ktp) }}" alt="KTP Preview" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none; flex-direction: column; align-items: center; justify-content: center;">
                                        <i class="fas fa-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                                        <span>{{ basename($pendaftaran->file_ktp) }}</span>
                                    </div>
                                @else
                                    <i class="fas fa-id-card"></i>
                                    <span>KTP</span>
                                @endif
                            </div>
                            <div class="document-upload-button mt-2">
                                <input type="file" name="file_ktp" id="file_ktp" class="document-upload-input @error('file_ktp') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                <label for="file_ktp" class="btn btn-outline-info w-100">
                                    <i class="fas fa-upload me-2"></i>{{ isset($pendaftaran) && $pendaftaran->file_ktp ? 'Change KTP' : 'Upload KTP' }}
                                </label>
                            </div>
                            @if(isset($pendaftaran) && $pendaftaran->file_ktp)
                                <small class="text-success d-block mt-1"><i class="fas fa-check"></i> Current: {{ basename($pendaftaran->file_ktp) }}</small>
                            @endif
                        </div>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max: 10MB</small>
                        @error('file_ktp')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Scan KTM --}}
                <div class="col-md-{{ $isSecondRegistration ? '3' : '4' }}" data-aos="fade-left" data-aos-delay="300">
                    <div class="form-group border rounded p-3 shadow-sm">
                        <label for="file_ktm" class="form-control-label fw-semibold">Scan KTM</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="ktm-preview">
                                @if(isset($pendaftaran) && $pendaftaran->file_ktm)
                                    <img src="{{ asset('storage/'.$pendaftaran->file_ktm) }}" alt="KTM Preview" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none; flex-direction: column; align-items: center; justify-content: center;">
                                        <i class="fas fa-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                                        <span>{{ basename($pendaftaran->file_ktm) }}</span>
                                    </div>
                                @else
                                    <i class="fas fa-address-card"></i>
                                    <span>KTM</span>
                                @endif
                            </div>
                            <div class="document-upload-button mt-2">
                                <input type="file" name="file_ktm" id="file_ktm" class="document-upload-input @error('file_ktm') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                <label for="file_ktm" class="btn btn-outline-info w-100">
                                    <i class="fas fa-upload me-2"></i>{{ isset($pendaftaran) && $pendaftaran->file_ktm ? 'Change KTM' : 'Upload KTM' }}
                                </label>
                            </div>
                            @if(isset($pendaftaran) && $pendaftaran->file_ktm)
                                <small class="text-success d-block mt-1"><i class="fas fa-check"></i> Current: {{ basename($pendaftaran->file_ktm) }}</small>
                            @endif
                        </div>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max: 10MB</small>
                        @error('file_ktm')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Pas Foto --}}
                <div class="col-md-{{ $isSecondRegistration ? '3' : '4' }}" data-aos="fade-left" data-aos-delay="400">
                    <div class="form-group border rounded p-3 shadow-sm">
                        <label for="file_foto" class="form-control-label fw-semibold">Pas Foto</label>
                        <div class="document-upload-container">
                            <div class="document-preview photo-preview" id="foto-preview">
                                @if(isset($pendaftaran) && $pendaftaran->file_foto)
                                    <img src="{{ asset('storage/'.$pendaftaran->file_foto) }}" alt="Foto Preview" class="rounded-circle">
                                @else
                                    <i class="fas fa-user"></i>
                                    <span>Foto</span>
                                @endif
                            </div>
                            <div class="document-upload-button mt-2">
                                <input type="file" name="file_foto" id="file_foto" class="document-upload-input @error('file_foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                                <label for="file_foto" class="btn btn-outline-info w-100">
                                    <i class="fas fa-upload me-2"></i>{{ isset($pendaftaran) && $pendaftaran->file_foto ? 'Change Foto' : 'Upload Foto' }}
                                </label>
                            </div>
                            @if(isset($pendaftaran) && $pendaftaran->file_foto)
                                <small class="text-success d-block mt-1"><i class="fas fa-check"></i> Current: {{ basename($pendaftaran->file_foto) }}</small>
                            @endif
                        </div>
                        <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                        @error('file_foto')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Bukti Pembayaran - Only for Second Registration --}}
                @if($isSecondRegistration)
                <div class="col-md-3" data-aos="fade-left" data-aos-delay="500">
                    <div class="form-group border rounded p-3 shadow-sm">
                        <label for="file_bukti_pembayaran" class="form-control-label fw-semibold">Bukti Pembayaran</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="bukti-preview">
                                @if(isset($pendaftaran) && $pendaftaran->file_bukti_pembayaran)
                                    <img src="{{ asset('storage/'.$pendaftaran->file_bukti_pembayaran) }}" alt="Bukti Pembayaran Preview" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none; flex-direction: column; align-items: center; justify-content: center;">
                                        <i class="fas fa-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                                        <span>{{ basename($pendaftaran->file_bukti_pembayaran) }}</span>
                                    </div>
                                @else
                                    <i class="fas fa-receipt"></i>
                                    <span>Bukti Bayar</span>
                                @endif
                            </div>
                            <div class="document-upload-button mt-2">
                                <input type="file" name="file_bukti_pembayaran" id="file_bukti_pembayaran" class="document-upload-input @error('file_bukti_pembayaran') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                <label for="file_bukti_pembayaran" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-upload me-2"></i>{{ isset($pendaftaran) && $pendaftaran->file_bukti_pembayaran ? 'Change Bukti' : 'Upload Bukti' }}
                                </label>
                            </div>
                            @if(isset($pendaftaran) && $pendaftaran->file_bukti_pembayaran)
                                <small class="text-success d-block mt-1"><i class="fas fa-check"></i> Current: {{ basename($pendaftaran->file_bukti_pembayaran) }}</small>
                            @endif
                        </div>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max: 10MB</small>
                        @error('file_bukti_pembayaran')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @endif
            </div>

            @if($isSecondRegistration)
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Pendaftaran Kedua:</strong> Anda sedang mengedit pendaftaran kedua. Bukti pembayaran diperlukan untuk pendaftaran ini.
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
                <button type="button" id="submitBtn" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Registration
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="confirmationModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Konfirmasi Penyimpanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-question-circle text-warning" style="font-size: 4rem;"></i>
                </div>
                <h5 class="mb-3">Apakah Anda sudah yakin?</h5>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian!</strong> Anda hanya dapat mengedit data pendaftaran satu kali. Setelah disimpan, Anda tidak dapat mengubah data ini lagi.
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" id="confirmSubmit" class="btn btn-primary">
                    <i class="fas fa-check me-2"></i>Ya, Saya Yakin
                </button>
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
            $(this).next('label').html('<i class="fas fa-check me-2"></i>File Selected');
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
            $(this).next('label').html('<i class="fas fa-check me-2"></i>File Selected');
        }
    });

    // Preview for Foto with circular styling
    $('#file_foto').change(function() {
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

    // Preview for Bukti Pembayaran (only if exists and is second registration)
    @if($isSecondRegistration)
    $('#file_bukti_pembayaran').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (file.type === 'application/pdf') {
                    $('#bukti-preview').html(`
                        <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>
                        <span>${file.name}</span>
                    `);
                } else {
                    $('#bukti-preview').html(`<img src="${e.target.result}" alt="Bukti Pembayaran Preview">`);
                }
                $('#bukti-preview').addClass('has-preview');
            }
            reader.readAsDataURL(file);
            $(this).next('label').html('<i class="fas fa-check me-2"></i>File Selected');
        }
    });
    @endif

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

    // Clean existing value on page load
    let currentValue = $('#wa').val();
    if (currentValue) {
        // Remove +62 prefix if exists
        currentValue = currentValue.replace(/^\+?62/, '');
        // Remove leading 0 if exists
        currentValue = currentValue.replace(/^0/, '');
        $('#wa').val(currentValue);
    }
    
    // Show confirmation modal when submit button is clicked
    $('#submitBtn').on('click', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        // Check form validity first
        const form = document.getElementById('editForm');
        if (form.checkValidity()) {
            $('#confirmationModal').modal('show');
        } else {
            // Trigger HTML5 validation
            form.reportValidity();
        }
    });
    
    // Submit form when confirmed
    $('#confirmSubmit').on('click', function() {
        $('#confirmationModal').modal('hide');
        
        // Add loading state
        $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
        $(this).prop('disabled', true);
        
        // Submit the form
        document.getElementById('editForm').submit();
    });
    
    // Reset button state when modal is hidden
    $('#confirmationModal').on('hidden.bs.modal', function () {
        $('#confirmSubmit').html('<i class="fas fa-check me-2"></i>Ya, Saya Yakin');
        $('#confirmSubmit').prop('disabled', false);
    });
});
</script>
@endpush
