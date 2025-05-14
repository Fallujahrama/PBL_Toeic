@extends('layouts.template')

@section('title', 'Daftar Notifikasi - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Notifikasi</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Daftar Notifikasi</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h5 class="mb-0">Daftar Notifikasi</h5>
                    </div>
                    <a href="{{ route('notifications.create') }}" class="btn btn-sm btn-primary" data-aos="fade-left">
                        <i class="fas fa-plus me-2"></i>Tambah Notifikasi
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success mx-4 mt-3" role="alert" data-aos="fade-up">
                        <div class="d-flex">
                            <div class="icon icon-shape icon-xs bg-gradient-success text-white rounded-circle shadow me-2">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                <div class="table-responsive p-0 mt-3">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Pesan</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notification)
                                <tr class="notification-row fade-in" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $notification->id }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-xs bg-gradient-info text-white rounded-circle shadow me-2">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                            <p class="text-xs font-weight-bold mb-0">{{ $notification->tanggal }}</p>
                                        </div>
                                    </td>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0 text-truncate" style="max-width: 300px;">
                                            {{ $notification->pesan }}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('notifications.show', $notification->id) }}" class="btn btn-link text-info px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-link text-warning px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger px-2 mb-0" onclick="return confirm('Yakin ingin menghapus?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
