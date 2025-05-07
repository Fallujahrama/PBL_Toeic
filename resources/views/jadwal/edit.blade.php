@extends('layout.template')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary">Edit Jadwal</h2>
    <form id="form-edit-jadwal">
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $jadwal->tanggal }}">
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $jadwal->nama }}">
        </div>
        <div class="mb-3">
            <label for="informasi" class="form-label">Informasi</label>
            <textarea class="form-control" id="informasi" name="informasi">{{ $jadwal->informasi }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection