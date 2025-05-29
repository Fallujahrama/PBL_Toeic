@extends('layouts.template')

@section('title', 'Edit Profil Admin')

@section('content')
<div class="container mt-4">
    <h4>Edit Profil Admin</h4>
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->admin->nama ?? '') }}" required>
            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>No. WhatsApp</label>
            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->admin->no_hp ?? '') }}" required>
            @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Password Baru <small>(kosongkan jika tidak ingin mengubah)</small></label>
            <input type="password" name="password" class="form-control">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('profile') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
