@extends('layouts.template')

@section('title', 'Detail Notifikasi - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('notifications.index') }}">Notifikasi</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Detail Notifikasi</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-info text-white rounded-circle shadow me-2">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5 class="mb-0">Detail Notifikasi</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                        <div class="notification-detail-card">
                            <div class="notification-header">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow me-3">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Notifikasi #{{ $notification->id }}</h6>
                                        <p class="text-sm mb-0">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            {{ $notification->tanggal }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-body">
                                <div class="notification-message">
                                    {{ $notification->pesan }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .notification-detail-card {
        background-color: var(--dark-card);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }
    
    .notification-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--dark-border);
    }
    
    .notification-body {
        padding: 1.5rem;
    }
    
    .notification-message {
        background-color: var(--dark-hover);
        padding: 1.5rem;
        border-radius: 0.5rem;
        border-left: 4px solid #3b82f6;
        font-size: 1rem;
        line-height: 1.6;
        white-space: pre-line;
    }
</style>
@endpush
