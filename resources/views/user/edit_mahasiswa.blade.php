@extends('layouts.template')

@section('title', 'Edit Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('profile') }}">Profile</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Profile</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Edit Profile</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header d-flex align-items-center">
                <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                    <i class="fas fa-edit"></i>
                </div>
                <h5 class="mb-0">Edit Profile Data</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nama" class="form-control-label">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama', isset($user->mahasiswa) ? $user->mahasiswa->nama : $user->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if(auth()->user()->level->level_kode === 'Mhs')
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="no_whatsapp" class="form-control-label">No. WhatsApp</label>
                                <input type="text" id="no_whatsapp" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror"
                                       value="{{ old('no_whatsapp', $user->mahasiswa->no_whatsapp ?? '') }}" required>
                                @error('no_whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password" class="form-control-label">Password Baru <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small></label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-control-label">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('profile') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
