@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">{{ $page->title }}</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm ms-auto">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-control-label">Nama Lengkap</label>
                                    <input class="form-control" type="text" name="nama" id="nama"
                                           value="{{ old('nama', $user->nama) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">Nama Pengguna</label>
                                    <input class="form-control" type="text" name="username" id="username"
                                           value="{{ old('username', $user->username) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-control-label">Kata Sandi</label>
                                    <input class="form-control" type="password" name="password" id="password">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah kata sandi</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level_id" class="form-control-label">Level Pengguna</label>
                                    <select class="form-control" name="level_id" id="level_id" required>
                                        <option value="">Pilih Level</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->level_id }}"
                                                    {{ old('level_id', $user->level_id) == $level->level_id ? 'selected' : '' }}>
                                                {{ $level->level_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
