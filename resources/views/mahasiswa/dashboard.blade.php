    @extends('layouts.template')

    @section('title', 'Dashboard Mahasiswa')

    @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dashboard Mahasiswa</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card bg-info text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="card-title">Pendaftaran TOEIC</h5>
                                                <p class="card-text">Daftar ujian TOEIC</p>
                                            </div>
                                            <i class="fas fa-clipboard-list fa-3x"></i>
                                        </div>
                                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-gradient mt-3">Lihat Pendaftaran</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="card-title">Jadwal TOEIC</h5>
                                                <p class="card-text">Lihat jadwal ujian TOEIC</p>
                                            </div>
                                            <i class="fas fa-calendar-alt fa-3x"></i>
                                        </div>
                                        <a href="{{ route('mahasiswa.jadwal') }}" class="btn btn-gradient mt-3">Lihat Jadwal</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card bg-warning text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="card-title">Hasil Ujian</h5>
                                                <p class="card-text">Lihat hasil ujian TOEIC</p>
                                            </div>
                                            <i class="fas fa-chart-bar fa-3x"></i>
                                        </div>
                                        <a href="{{ route('mahasiswa.hasil_ujian') }}" class="btn btn-gradient mt-3">Lihat Hasil</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Notifikasi Terbaru</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group">
                                            <!-- Placeholder for notifications -->
                                            <a href="{{ route('mahasiswa.notifikasi.index') }}" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Lihat semua notifikasi</h5>
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Informasi Akun</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>NIM:</strong> {{ Auth::user()->username }}</p>
                                        <a href="{{ route('profile') }}" class="btn btn-primary">Edit Profil</a>
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
