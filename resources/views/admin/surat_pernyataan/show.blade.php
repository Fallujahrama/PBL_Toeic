@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>{{ $page->title }}</h6>
                    <a href="{{ route('admin.surat-pernyataan.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Informasi Mahasiswa</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>NIM:</strong></td>
                                            <td>{{ $surat->nim }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td>{{ $surat->mahasiswa->nama ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Program Studi:</strong></td>
                                            <td>{{ $surat->mahasiswa->program_studi ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jurusan:</strong></td>
                                            <td>{{ $surat->mahasiswa->jurusan ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Informasi Dokumen</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($surat->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu Validasi</span>
                                                @elseif($surat->status == 'valid')
                                                    <span class="badge bg-success">Valid</span>
                                                @elseif($surat->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Upload:</strong></td>
                                            <td>{{ $surat->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Berkas:</strong></td>
                                            <td>
                                                <a href="{{ Storage::url('surat/' . $surat->file_surat_pernyataan) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    @if($surat->status == 'pending')
                                    <div class="mt-3">
                                        <form action="{{ route('admin.surat-pernyataan.validate', $surat->id_surat_pernyataan) }}" method="POST" class="d-inline me-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success" onclick="return confirm('Validasi dokumen ini?')">
                                                <i class="fas fa-check"></i> Validasi
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.surat-pernyataan.reject', $surat->id_surat_pernyataan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak dokumen ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Pratinjau Dokumen</h6>
                                </div>
                                <div class="card-body">
                                    <iframe src="{{ Storage::url('surat/' . $surat->file_surat_pernyataan) }}"
                                            width="100%" height="600px" style="border: none;">
                                        <p>Browser Anda tidak mendukung preview PDF.
                                           <a href="{{ Storage::url('surat/' . $surat->file_surat_pernyataan) }}" target="_blank">Klik di sini untuk membuka file</a>
                                        </p>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
