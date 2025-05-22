@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    @include('layouts.breadcrumb')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $page->title }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal" class="form-control-label">Tanggal</label>
                                <p class="form-control-static">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="waktu" class="form-control-label">Waktu</label>
                                <p class="form-control-static">{{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempat" class="form-control-label">Tempat</label>
                                <p class="form-control-static">{{ $jadwal->tempat }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kuota" class="form-control-label">Kuota</label>
                                <p class="form-control-static">{{ $jadwal->kuota }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan" class="form-control-label">Keterangan</label>
                                <p class="form-control-static">{{ $jadwal->keterangan }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($jadwal->file_path)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="file" class="form-control-label">File Jadwal</label>
                                <div class="mt-2">
                                    <a href="{{ route('jadwal.preview', $jadwal->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-2"></i> Lihat File
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a href="{{ route('mahasiswa.jadwal') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
