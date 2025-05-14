@extends('layouts.template')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container-fluid"> 
    <div class="row justify-content-center">
        <div class="col-12"> 
            <div class="card shadow-sm" style="background-color: #f8f9fa;"> 
                <div class="card-header text-center">
                    <h2 class="fw-bold">TOEIC Test Registration</h2> 
                    <p>Please select the registration type</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Mahasiswa Baru -->
                        <div class="col-md-6 mb-3">
                            <div class="card p-4 text-center h-100 shadow-sm" style="border: 1px solid #e0e0e0; background-color: #eaf4ff; cursor: pointer;" onclick="window.location='{{ route('pendaftaran.baru') }}'">
                                <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                                <h4>First Registration</h4>
                                <p>Firs Registration Form</p>
                            </div>
                        </div>
                        <!-- Mahasiswa Lama -->
                        <div class="col-md-6 mb-3">
                            <div class="card p-4 text-center h-100 shadow-sm" style="border: 1px solid #e0e0e0; background-color: #fff5e6; cursor: pointer;" onclick="window.location='{{ route('pendaftaran.lama') }}'">
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
        <div class="col-md-12">
            <div class="card p-4 shadow-sm" style="background-color: #eaf4ff;">
                <h5>First Registration</h5>
                <p class="text-muted">This registration form for students who are taking the TOEIC exam for the first time.</p>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card p-4 shadow-sm" style="background-color: #fff5e6;">
                <h5>Second Registration</h5>
                <p class="text-muted">This registration form for students who have previously taken the TOEIC exam.</p>
            </div>
        </div>
    </div>
</div>

@endsection
