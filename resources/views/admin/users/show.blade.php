@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">{{ $page->title }}</p>
                        <div class="ms-auto">
                            <a href="{{ route('admin.users.edit', $user->id_user) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar avatar-xxl position-relative">
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                @else
                                    <img src="{{ asset('img/default-avatar.png') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Nama Lengkap</label>
                                        <p class="form-control-static">{{ $user->nama ?? 'Tidak ada nama' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Username</label>
                                        <p class="form-control-static">{{ $user->username }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Level User</label>
                                        <p class="form-control-static">
                                            <span class="badge badge-lg 
                                                @if($user->level->level_kode == 'SprAdmin') bg-gradient-danger
                                                @elseif($user->level->level_kode == 'AdmUpa') bg-gradient-warning
                                                @elseif($user->level->level_kode == 'AdmITC') bg-gradient-info
                                                @else bg-gradient-success
                                                @endif">
                                                {{ $user->level->level_nama }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Tanggal Dibuat</label>
                                        <p class="form-control-static">
                                            {{ $user->created_at ? $user->created_at->format('d F Y, H:i') : 'Tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Terakhir Diupdate</label>
                                        <p class="form-control-static">
                                            {{ $user->updated_at ? $user->updated_at->format('d F Y, H:i') : 'Tidak tersedia' }}
                                        </p>
                                    </div>
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
