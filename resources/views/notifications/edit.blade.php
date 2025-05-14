@extends('layouts.template')

@section('title', 'Edit Notifikasi - TOEIC Center')

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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Edit Notifikasi</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-warning text-white rounded-circle shadow me-2">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h5 class="mb-0">Edit Notifikasi</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('notifications.update', $notification->id) }}" method="POST" id="notification-form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                            <div class="form-group">
                                <label for="tanggal" class="form-control-label">Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $notification->tanggal }}" required>
                                </div>
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12" data-aos="fade-left" data-aos-delay="200">
                            <div class="form-group">
                                <label for="pesan" class="form-control-label">Pesan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-comment-alt"></i></span>
                                    <textarea name="pesan" id="pesan" class="form-control" rows="4" required>{{ $notification->pesan }}</textarea>
                                </div>
                                @error('pesan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Form validation
        $('#notification-form').on('submit', function(e) {
            let isValid = true;
            
            if ($('#tanggal').val() === '') {
                isValid = false;
                $('#tanggal').addClass('is-invalid');
            } else {
                $('#tanggal').removeClass('is-invalid');
            }
            
            if ($('#pesan').val().trim() === '') {
                isValid = false;
                $('#pesan').addClass('is-invalid');
            } else {
                $('#pesan').removeClass('is-invalid');
            }
            
            return isValid;
        });
    });
</script>
@endpush
