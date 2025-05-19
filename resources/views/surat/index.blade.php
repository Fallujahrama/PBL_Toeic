@extends('layouts.template')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title mb-0">Formulir Unggah Surat Pernyataan TOEIC</h4>
        </div>

        <div class="card-body">
            {{-- Form --}}
            <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nim">NIM</label>
                            <input type="text" name="nim" id="nim" class="form-control" value="{{ $mahasiswa->nim }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="program_studi">Program Studi</label>
                            <input type="text" id="program_studi" class="form-control" value="{{ $mahasiswa->program_studi }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" id="jurusan" class="form-control" value="{{ $mahasiswa->jurusan }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kampus">Kampus</label>
                            <input type="text" id="kampus" class="form-control" value="{{ $mahasiswa->kampus }}" readonly>
                        </div>
                    </div>
                </div>

                {{-- Status Dokumen --}}
                <div class="mb-4 p-3 border-start border-4 rounded bg-light shadow-sm">
                    <strong class="text-primary">Status Dokumen : </strong>
                    <span class="ms-2">
                        @if ($surat)
                            @php
                                $status = strtolower($surat->status);
                                $badgeColor = match($status) {
                                    'disetujui' => 'success',
                                    'ditolak' => 'danger',
                                    'diproses' => 'primary',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeColor }} text-uppercase">{{ $surat->status }}</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum ada pengajuan</span>
                        @endif
                    </span>
                </div>

                {{-- Input Upload File --}}
                @if (!$surat)
                    <div class="form-group mb-3">
                        <label for="file_surat_pernyataan">Unggah bukti keikutsertaan ujian TOEIC pertama</label>
                        <input type="file" name="file_surat_pernyataan" id="file_surat_pernyataan" class="form-control" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload"></i> Unggah Dokumen
                        </button>
                    </div>
                @endif
            </form>

            {{-- Jika sudah ada dokumen --}}
            @if ($surat)
                <hr>
                <div class="mt-4">
                    <a href="{{ route('surat.show', $surat->id_surat_pernyataan) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-1"></i> Lihat Dokumen
                    </a>

                    <form action="{{ route('surat.destroy', $surat->id_surat_pernyataan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">
                            <i class="fas fa-trash-alt"></i> Hapus Dokumen
                        </button>
                    </form>

                    <p class="text-muted mt-2">Untuk mengganti dokumen, hapus terlebih dahulu dokumen yang telah diunggah.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection