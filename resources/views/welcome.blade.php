@extends('layouts.template')

@section('title', 'Welcome Page')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                @foreach($breadcrumb->list as $key => $value)
                    @if ($key < count($breadcrumb->list) - 1)
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-dark" href="#">{{ $value }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $value }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
        <h6 class="font-weight-bolder mb-0">{{ $breadcrumb->title }}</h6>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h5 class="text-white">Selamat Datang di Sistem Pendaftaran TOEIC</h5>
                    <p class="mb-0">Silakan cek jadwal terbaru, persyaratan, dan segera daftarkan dirimu untuk mengikuti tes TOEIC!</p>
                </div>
            </div>
        </div>

        <!-- Card Info Jadwal -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h6>Jadwal Tes TOEIC Terdekat</h6>
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>Gelombang 1:</strong> 20 Mei 2025</li>
                        <li><strong>Gelombang 2:</strong> 10 Juni 2025</li>
                        <li><strong>Lokasi:</strong> Laboratorium Bahasa, Gedung E</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card Info Persyaratan -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h6>Persyaratan Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Mahasiswa aktif</li>
                        <li>Upload KTM (Kartu Tanda Mahasiswa)</li>
                        <li>Biaya pendaftaran: Rp150.000</li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
@endsection
