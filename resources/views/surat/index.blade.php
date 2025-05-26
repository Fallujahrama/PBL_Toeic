@extends('layouts.template')

@section('content')
<div class="container-fluid">
    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-upload me-2"></i>Upload Surat Pernyataan</h3>
        </div>
        <div class="card-body">
            {{-- Tombol Download Template --}}
            <div class="mb-4">
                <a href="{{ asset('adminlte/surat-pernyataan-template.pdf') }}" download class="btn btn-outline-primary">
                    <i class="fas fa-download"></i> Download Template Surat Pernyataan
                </a>
            </div>

            {{-- Jika sudah ada dokumen --}}
            @if ($surat)
                <div class="alert alert-info">
                    <strong>Status Dokumen:</strong> {{ ucfirst($surat->status) }}
                </div>

                <div class="mb-3">
                    <a href="{{ Storage::url('surat/' . $surat->file_surat_pernyataan) }}" target="_blank" class="btn btn-outline-info me-2">
                        <i class="fas fa-eye"></i> Lihat Dokumen
                    </a>

                    <form action="{{ route('surat.destroy', $surat->id_surat_pernyataan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>

                <small class="text-muted">
                    Untuk mengganti dokumen, silakan hapus dokumen yang sudah diunggah terlebih dahulu.
                </small>
            @else
                {{-- Form Upload --}}
                <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="nim" value="{{ auth()->user()->mahasiswa->nim ?? '' }}"> {{-- Relasi mahasiswa --}}

                    <div class="form-group mb-3">
                        <label for="file_surat_pernyataan">Upload Surat Pernyataan (PDF)</label>
                        <input type="file" name="file_surat_pernyataan" id="file_surat_pernyataan"
                               class="form-control" accept="application/pdf" required>
                        <small class="form-text text-muted">
                            Format file: PDF, maksimal ukuran 2MB.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
