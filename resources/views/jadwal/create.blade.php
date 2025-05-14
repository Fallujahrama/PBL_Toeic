@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Tambah Jadwal</h1>
    <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="informasi">Informasi</label>
            <input type="text" name="informasi" id="informasi" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="file_info">File (Opsional)</label>
            <input type="file" name="file_info" id="file_info" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
