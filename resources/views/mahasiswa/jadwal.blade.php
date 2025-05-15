@extends('layout.template')
@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Jadwal Ujian Saya</h2>
        <p class="text-muted">Berikut adalah jadwal ujian Anda.</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID Jadwal</th>
                    <th>Tanggal</th>
                    <th>Informasi</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalMahasiswa as $item)
                <tr>
                    <td>{{ $item->jadwal_id }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->informasi }}</td>
                    <td>
                        <a href="{{ asset($item->file_info) }}" class="btn btn-success btn-sm" target="_blank">
                            <i class="bi bi-file-earmark"></i> File
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection