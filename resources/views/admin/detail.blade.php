@extends('layout.template')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Detail Pendaftaran</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>NIM:</strong> {{ $pendaftaran->nim }}</p>
                    <p><strong>Nama:</strong> {{ $pendaftaran->mahasiswa->nama }}</p>
                    <p><strong>Jurusan:</strong> {{ $pendaftaran->mahasiswa->jurusan ?? '-' }}</p>
                    <p><strong>Program Studi:</strong> {{ $pendaftaran->mahasiswa->program_studi ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>No. WhatsApp:</strong> {{ $pendaftaran->mahasiswa->no_whatsapp ?? '-' }}</p>
                    <p><strong>Alamat Saat Ini:</strong> {{ $pendaftaran->mahasiswa->alamat_saat_ini ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Dokumen Pendaftaran</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <h5>KTP</h5>
                    <img src="{{ asset('storage/' . $pendaftaran->file_ktp) }}" 
                         class="img-fluid img-thumbnail" 
                         style="max-height: 300px;">
                    <a href="{{ asset('storage/' . $pendaftaran->file_ktp) }}" 
                       target="_blank" class="btn btn-sm btn-primary mt-2">
                        <i class="fas fa-download"></i> Unduh
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <h5>KTM</h5>
                    <img src="{{ asset('storage/' . $pendaftaran->file_ktm) }}" 
                         class="img-fluid img-thumbnail" 
                         style="max-height: 300px;">
                    <a href="{{ asset('storage/' . $pendaftaran->file_ktm) }}" 
                       target="_blank" class="btn btn-sm btn-primary mt-2">
                        <i class="fas fa-download"></i> Unduh
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Foto</h5>
                    <img src="{{ asset('storage/' . $pendaftaran->file_foto) }}" 
                         class="img-fluid img-thumbnail" 
                         style="max-height: 300px;">
                    <a href="{{ asset('storage/' . $pendaftaran->file_foto) }}" 
                       target="_blank" class="btn btn-sm btn-primary mt-2">
                        <i class="fas fa-download"></i> Unduh
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Verifikasi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.verifikasi.verify', $pendaftaran->id_pendaftaran) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="status">Status Verifikasi</label>
                    <select name="status" id="status" class="form-control">
                        <option value="approved" {{ $pendaftaran->status_verifikasi == 'approved' ? 'selected' : '' }}>
                            Setujui
                        </option>
                        <option value="rejected" {{ $pendaftaran->status_verifikasi == 'rejected' ? 'selected' : '' }}>
                            Tolak
                        </option>
                        <option value="pending" {{ $pendaftaran->status_verifikasi == 'pending' || !$pendaftaran->status_verifikasi ? 'selected' : '' }}>
                            Menunggu
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.verifikasi') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection