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
                                <label for="nim" class="form-control-label">NIM</label>
                                <p class="form-control-static">{{ $hasil_ujian->nim }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-control-label">Nama</label>
                                <p class="form-control-static">{{ $hasil_ujian->nama }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_ujian" class="form-control-label">Tanggal Ujian</label>
                                <p class="form-control-static">{{ \Carbon\Carbon::parse($hasil_ujian->tanggal_ujian)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempat_ujian" class="form-control-label">Tempat Ujian</label>
                                <p class="form-control-static">{{ $hasil_ujian->tempat_ujian }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6 class="mb-3">Hasil Skor</h6>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-gradient-primary text-white">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Skor</p>
                                                <h5 class="font-weight-bolder text-white mb-0">
                                                    {{ $hasil_ujian->skor_total }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                <i class="ni ni-trophy text-dark text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-gradient-info text-white">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Listening</p>
                                                <h5 class="font-weight-bolder text-white mb-0">
                                                    {{ $hasil_ujian->skor_listening }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                <i class="ni ni-headphones text-dark text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-gradient-success text-white">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Reading</p>
                                                <h5 class="font-weight-bolder text-white mb-0">
                                                    {{ $hasil_ujian->skor_reading }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                <i class="ni ni-books text-dark text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($hasil_ujian->keterangan)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan" class="form-control-label">Keterangan</label>
                                <p class="form-control-static">{{ $hasil_ujian->keterangan }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($hasil_ujian->sertifikat_path)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sertifikat" class="form-control-label">Sertifikat</label>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $hasil_ujian->sertifikat_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-2"></i> Download Sertifikat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a href="{{ route('mahasiswa.hasil_ujian') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
