@extends('layouts.template')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/') }}">Home</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pendaftaran</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $page->title ?? 'Pendaftaran Mahasiswa' }}</h6>
</div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container-fluid"> 
    <div class="row justify-content-center">
        <div class="col-12"> 
            <div class="card shadow-sm animate-card" data-aos="fade-up"> 
                <div class="card-header text-center">
                    <h2 class="fw-bold">TOEIC Test Registration</h2> 
                    <p>Please select the registration type</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Mahasiswa Baru -->
                        <div class="col-md-6 mb-3" data-aos="fade-right" data-aos-delay="100">
                            <div class="card p-4 text-center h-100 shadow-sm animate-card" style="border: 1px solid var(--dark-border); background-color: var(--dark-card); cursor: pointer;" onclick="window.location='{{ route('pendaftaran.baru') }}'">
                                <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                                <h4>First Registration</h4>
                                <p>First Registration Form</p>
                            </div>
                        </div>
                        <!-- Mahasiswa Lama -->
                        <div class="col-md-6 mb-3" data-aos="fade-left" data-aos-delay="200">
                            <div class="card p-4 text-center h-100 shadow-sm animate-card" style="border: 1px solid var(--dark-border); background-color: var(--dark-card); cursor: pointer;" onclick="window.location='{{ route('pendaftaran.lama') }}'">
                                <i class="fas fa-user-edit fa-3x mb-3 text-warning"></i>
                                <h4>Second Registration</h4>
                                <p>Second Registration Form</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Penjelasan di bawah card -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-12" data-aos="fade-up" data-aos-delay="300">
            <div class="card p-4 shadow-sm animate-card" style="background-color: var(--dark-card); border: 1px solid var(--dark-border);">
                <h5><i class="fas fa-info-circle me-2 text-primary"></i>First Registration</h5>
                <p class="text-muted">This registration form for students who are taking the TOEIC exam for the first time.</p>
            </div>
        </div>
        <div class="col-md-12 mt-3" data-aos="fade-up" data-aos-delay="400">
            <div class="card p-4 shadow-sm animate-card" style="background-color: var(--dark-card); border: 1px solid var(--dark-border);">
                <h5><i class="fas fa-info-circle me-2 text-warning"></i>Second Registration</h5>
                <p class="text-muted">This registration form for students who have previously taken the TOEIC exam.</p>
            </div>
        </div>
    </div>
</div>
@endsection
