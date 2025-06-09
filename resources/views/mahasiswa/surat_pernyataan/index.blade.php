@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $page->title ?? 'Surat Pernyataan TOEIC' }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container-fluid">
                        {{-- Alert sukses --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card card-primary shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-paper-plane me-2"></i>Ajukan Surat Pernyataan TOEIC</h3>
                            </div>
                            <div class="card-body">
                                @if ($surat)
                                    <div class="alert alert-info">
                                        <strong>Status Dokumen:</strong>
                                        @if($surat->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Validasi</span>
                                        @elseif($surat->status == 'valid')
                                            <span class="badge bg-success">Valid</span>
                                        @elseif($surat->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </div>

                                    <div>
                                        <p>Surat pernyataan Anda telah diajukan pada: {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y H:i') }}</p>

                                        @if($surat->status == 'valid' && $surat->file_surat_pernyataan)
                                            <div class="mb-4">
                                                <p>Surat pernyataan Anda telah divalidasi. Silakan lihat file berikut:</p>

                                                <div class="d-flex gap-2">
                                                    <a href="{{ url('/mahasiswa/surat-pernyataan/preview/'.$surat->id_surat_pernyataan) }}"
                                                       target="_blank" class="btn btn-info">
                                                        <i class="fas fa-eye me-1"></i> Preview Dokumen
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        @if($surat->status == 'rejected')
                                            <div class="alert alert-warning">
                                                <p class="mb-0">Surat pernyataan Anda ditolak. Silakan ajukan kembali.</p>
                                            </div>
                                            <form action="{{ route('mahasiswa.surat-pernyataan.ajukan') }}" method="POST" class="mt-3">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i> Ajukan Kembali
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <p class="mb-0">Anda belum mengajukan surat pernyataan TOEIC.</p>
                                    </div>

                                    <form action="{{ route('mahasiswa.surat-pernyataan.ajukan') }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> Ajukan Surat Pernyataan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
