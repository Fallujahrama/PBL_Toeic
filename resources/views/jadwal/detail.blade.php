@extends('layout.template')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary">Detail Jadwal</h2>
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID Jadwal</th>
            <td>{{ $jadwal->id_jadwal }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $jadwal->tanggal }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $jadwal->nama }}</td>
        </tr>
        <tr>
            <th>Informasi</th>
            <td>{{ $jadwal->informasi }}</td>
        </tr>
        <tr>
            <th>File Info</th>
            <td>{{ $jadwal->file_info }}</td>
        </tr>
    </table>
    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection