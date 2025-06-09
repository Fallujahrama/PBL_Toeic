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
                            <strong>Error:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-control-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input class="form-control @error('nama') is-invalid @enderror"
                                           type="text"
                                           name="nama"
                                           id="nama"
                                           value="{{ old('nama') }}"
                                           required
                                           placeholder="Masukkan nama lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">Nama Pengguna/NIM <span class="text-danger">*</span></label>
                                    <input class="form-control @error('username') is-invalid @enderror"
                                           type="text"
                                           name="username"
                                           id="username"
                                           value="{{ old('username') }}"
                                           required
                                           placeholder="Masukkan NIM atau Username">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-control-label">Kata Sandi <span class="text-danger">*</span></label>
                                    <input class="form-control @error('password') is-invalid @enderror"
                                           type="password"
                                           name="password"
                                           id="password"
                                           required
                                           placeholder="Masukkan password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level_id" class="form-control-label">Level Pengguna <span class="text-danger">*</span></label>
                                    <select class="form-control @error('level_id') is-invalid @enderror"
                                            name="level_id"
                                            id="level_id"
                                            required>
                                        <option value="">Pilih Level</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                                {{ $level->level_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('level_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Debug form data before submission
    $('#createUserForm').on('submit', function(e) {
        console.log('Form data:');
        console.log('Nama:', $('#nama').val());
        console.log('Username:', $('#username').val());
        console.log('Level ID:', $('#level_id').val());

        // Show loading state
        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        // Let the form submit normally
        return true;
    });
});
</script>
@endpush
