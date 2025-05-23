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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Mahasiswa Baru</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $page->title ?? 'Form Pendaftaran Mahasiswa Baru' }}</h6>
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
        <form action="{{ route('pendaftaran.storeBaru') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="form-group">
                        <label for="nama" class="form-control-label">Nama</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
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
                            <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ auth()->user()->username }}" readonly>
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
                            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required>
                        </div>
                        @error('nik')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="form-group">
                        <label for="wa" class="form-control-label">No. WA</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" name="wa" id="wa" class="form-control @error('wa') is-invalid @enderror" value="{{ old('wa') }}" required>
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
                            <textarea name="alamat_asal" id="alamat_asal" class="form-control @error('alamat_asal') is-invalid @enderror" required>{{ old('alamat_asal') }}</textarea>
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
                            <textarea name="alamat_sekarang" id="alamat_sekarang" class="form-control @error('alamat_sekarang') is-invalid @enderror" required>{{ old('alamat_sekarang') }}</textarea>
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
                            <input type="text" name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror" value="{{ old('prodi') }}" required>
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
                            <input type="text" name="jurusan" id="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ old('jurusan') }}" required>
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
                                <option value="Utama" {{ old('kampus') == 'Utama' ? 'selected' : '' }}>Utama</option>
                                <option value="PSDKU Kediri" {{ old('kampus') == 'PSDKU Kediri' ? 'selected' : '' }}>PSDKU Kediri</option>
                                <option value="PSDKU Lumajang" {{ old('kampus') == 'PSDKU Lumajang' ? 'selected' : '' }}>PSDKU Lumajang</option>
                                <option value="PSDKU Pamekasan" {{ old('kampus') == 'PSDKU Pamekasan' ? 'selected' : '' }}>PSDKU Pamekasan</option>
                            </select>
                        </div>
                        @error('kampus')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="form-group">
                        <label for="ktp" class="form-control-label">Scan KTP</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="ktp-preview">
                                <i class="fas fa-id-card"></i>
                                <span>KTP</span>
                            </div>
                            <div class="document-upload-button">
                                <input type="file" name="ktp" id="ktp" class="document-upload-input @error('ktp') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                <label for="ktp" class="btn btn-outline-primary w-50 mx-auto d-block">
                                    <i class="fas fa-upload me-2"></i>Upload KTP
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, PDF. Maks: 10MB</small>
                        @error('ktp')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="form-group">
                        <label for="scan_ktm" class="form-control-label">Scan KTM</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="ktm-preview">
                                <i class="fas fa-address-card"></i>
                                <span>KTM</span>
                            </div>
                            <div class="document-upload-button">
                                <input type="file" name="scan_ktm" id="scan_ktm" class="document-upload-input @error('scan_ktm') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                <label for="scan_ktm" class="btn btn-outline-primary w-50 mx-auto d-block">
                                    <i class="fas fa-upload me-2"></i>Upload KTM
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, PDF. Maks: 10MB</small>
                        @error('scan_ktm')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="form-group">
                        <label for="pas_foto" class="form-control-label">Pas Foto Terbaru</label>
                        <div class="document-upload-container">
                            <div class="document-preview" id="foto-preview">
                                <i class="fas fa-user"></i>
                                <span>Foto</span>
                            </div>
                            <div class="document-upload-button">
                                <input type="file" name="pas_foto" id="pas_foto" class="document-upload-input @error('pas_foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" required>
                                <label for="pas_foto" class="btn btn-outline-primary w-50 mx-auto d-block">
                                    <i class="fas fa-upload me-2"></i>Upload Foto
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                        @error('pas_foto')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ url('pendaftaran') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Submit
                </button>
            </div>
        </form>
    </div>
</div>

@push('css')
<link href="{{ asset('css/jadwal.css') }}" rel="stylesheet">
@endpush

@push('js')
<script>
    $(document).ready(function() {
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
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File dipilih');
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
                $(this).next('label').html('<i class="fas fa-check me-2"></i>File dipilih');
            }
        });

        // Preview for Foto
        $('#pas_foto').change(function() {
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

@endsection
