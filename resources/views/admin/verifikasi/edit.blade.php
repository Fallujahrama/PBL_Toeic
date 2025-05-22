@extends('layouts.template')

@section('title', 'Edit Pendaftaran - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('verifikasi.index') }}">Verifikasi</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $page->title ?? 'Edit Pendaftaran' }}</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-warning text-white rounded-circle shadow me-2">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h5 class="mb-0">Form Edit Pendaftaran</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('verifikasi.update', $pendaftaran->id_pendaftaran) }}" method="POST" enctype="multipart/form-data" id="pendaftaran-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                            <div class="form-group">
                                <label for="nim" class="form-control-label">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" class="form-control" value="{{ $pendaftaran->nim }}" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
                            <div class="form-group">
                                <label for="status_verifikasi" class="form-control-label">Status Verifikasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                    <select name="status_verifikasi" id="status_verifikasi" class="form-control @error('status_verifikasi') is-invalid @enderror" required>
                                        <option value="pending" {{ $pendaftaran->status_verifikasi == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="approved" {{ $pendaftaran->status_verifikasi == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="rejected" {{ $pendaftaran->status_verifikasi == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                @error('status_verifikasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12" data-aos="fade-up" data-aos-delay="200">
                            <div class="form-group">
                                <label for="keterangan" class="form-control-label">Keterangan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-comment-alt"></i></span>
                                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Tambahkan catatan atau keterangan (opsional)">{{ old('keterangan', $pendaftaran->keterangan) }}</textarea>
                                </div>
                                @error('keterangan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12" data-aos="fade-up" data-aos-delay="300">
                            <h6 class="mb-3">Dokumen Pendaftaran</h6>
                        </div>
                        
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="400">
                            <div class="form-group">
                                <label for="file_ktp" class="form-control-label">KTP</label>
                                <div class="document-upload-container">
                                    <div class="document-preview {{ $pendaftaran->file_ktp ? 'has-preview' : '' }}" id="ktp-preview">
                                        @if($pendaftaran->file_ktp)
                                            @php
                                                $extension = pathinfo($pendaftaran->file_ktp, PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $pendaftaran->file_ktp) }}" alt="KTP Preview">
                                            @else
                                                <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>
                                                <span>PDF File</span>
                                            @endif
                                        @else
                                            <i class="fas fa-id-card"></i>
                                            <span>KTP</span>
                                        @endif
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_ktp" id="file_ktp" class="document-upload-input @error('file_ktp') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                        <label for="file_ktp" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>{{ $pendaftaran->file_ktp ? 'Ganti KTP' : 'Upload KTP' }}
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF. Maks: 10MB</small>
                                @if($pendaftaran->file_ktp)
                                    <div class="mt-2">
                                        <a href="{{ route('verifikasi.download', ['id' => $pendaftaran->id_pendaftaran, 'type' => 'ktp']) }}" class="text-primary">
                                            <i class="fas fa-download me-1"></i>Download File
                                        </a>
                                    </div>
                                @endif
                                @error('file_ktp')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6" data-aos="fade-left" data-aos-delay="400">
                            <div class="form-group">
                                <label for="file_ktm" class="form-control-label">KTM</label>
                                <div class="document-upload-container">
                                    <div class="document-preview {{ $pendaftaran->file_ktm ? 'has-preview' : '' }}" id="ktm-preview">
                                        @if($pendaftaran->file_ktm)
                                            @php
                                                $extension = pathinfo($pendaftaran->file_ktm, PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $pendaftaran->file_ktm) }}" alt="KTM Preview">
                                            @else
                                                <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444;"></i>
                                                <span>PDF File</span>
                                            @endif
                                        @else
                                            <i class="fas fa-address-card"></i>
                                            <span>KTM</span>
                                        @endif
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_ktm" id="file_ktm" class="document-upload-input @error('file_ktm') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,application/pdf">
                                        <label for="file_ktm" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>{{ $pendaftaran->file_ktm ? 'Ganti KTM' : 'Upload KTM' }}
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF. Maks: 10MB</small>
                                @if($pendaftaran->file_ktm)
                                    <div class="mt-2">
                                        <a href="{{ route('verifikasi.download', ['id' => $pendaftaran->id_pendaftaran, 'type' => 'ktm']) }}" class="text-primary">
                                            <i class="fas fa-download me-1"></i>Download File
                                        </a>
                                    </div>
                                @endif
                                @error('file_ktm')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="500">
                            <div class="form-group">
                                <label for="file_foto" class="form-control-label">Pas Foto</label>
                                <div class="document-upload-container">
                                    <div class="document-preview {{ $pendaftaran->file_foto ? 'has-preview' : '' }}" id="foto-preview">
                                        @if($pendaftaran->file_foto)
                                            <img src="{{ asset('storage/' . $pendaftaran->file_foto) }}" alt="Foto Preview">
                                        @else
                                            <i class="fas fa-user"></i>
                                            <span>Foto</span>
                                        @endif
                                    </div>
                                    <div class="document-upload-button">
                                        <input type="file" name="file_foto" id="file_foto" class="document-upload-input @error('file_foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                                        <label for="file_foto" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>{{ $pendaftaran->file_foto ? 'Ganti Foto' : 'Upload Foto' }}
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                                @if($pendaftaran->file_foto)
                                    <div class="mt-2">
                                        <a href="{{ route('verifikasi.download', ['id' => $pendaftaran->id_pendaftaran, 'type' => 'foto']) }}" class="text-primary">
                                            <i class="fas fa-download me-1"></i>Download File
                                        </a>
                                    </div>
                                @endif
                                @error('file_foto')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4" data-aos="fade-up" data-aos-delay="600">
                        <div>
                            <a href="{{ route('verifikasi.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('verifikasi.show', $pendaftaran->id_pendaftaran) }}" class="btn btn-info me-2">
                                <i class="fas fa-eye me-2"></i>Detail
                            </a>
                            <button type="button" class="btn btn-danger delete-btn" data-id="{{ $pendaftaran->id_pendaftaran }}">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pendaftaran ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="{{ route('verifikasi.destroy', $pendaftaran->id_pendaftaran) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
    }
    
    .document-upload-input {
        display: none;
    }
</style>
@endpush

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
        
        // Delete confirmation
        $('.delete-btn').on('click', function() {
            $('#deleteModal').modal('show');
        });
    });
</script>
@endpush
