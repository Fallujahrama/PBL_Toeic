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

        <form action="{{ route('mahasiswa.data.update', $mahasiswa->nim) }}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" name="wa" id="wa" class="form-control @error('wa') is-invalid @enderror" value="{{ old('wa', $mahasiswa->no_whatsapp ?? '') }}" required>
                        </div>
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
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
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
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="300">
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
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="400">
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
            </div>

            <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('pendaftaran.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Registration
                </button>
            </div>
        </form>
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

    // Click on preview to trigger file input
    $('.document-preview').click(function() {
        const container = $(this).closest('.form-group');
        const input = container.find('input[type="file"]');
        input.click();
    });
});
</script>
@endpush
