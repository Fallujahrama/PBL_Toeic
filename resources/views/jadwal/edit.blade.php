@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Edit Jadwal</h1>
    <form action="{{ route('jadwal.update', $jadwal->jadwal_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $jadwal->tanggal }}" required>
        </div>
        <div class="form-group">
            <label for="informasi">Informasi</label>
            <input type="text" name="informasi" id="informasi" class="form-control" value="{{ $jadwal->informasi }}" required>
        </div>
        <div class="form-group">
            <label for="file_info">File (Opsional)</label>
            <input type="file" name="file_info" id="file_info" class="form-control">
            @if ($jadwal->file_info)
                <p>File saat ini: <a href="{{ asset('storage/' . $jadwal->file_info) }}" target="_blank">Lihat File</a></p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
