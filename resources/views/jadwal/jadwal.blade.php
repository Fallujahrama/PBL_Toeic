@extends('layout.template')

@section('content')
<div class="container mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-primary">Home</a></li>
            <li class="breadcrumb-item active text-dark" aria-current="page">Jadwal</li>
        </ol>
    </nav>

    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Jadwal Ujian Mahasiswa</h2>
        <p class="text-muted">Berikut adalah jadwal ujian mahasiswa yang telah terdaftar.</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID Jadwal</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Informasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $item)
                <tr>
                    <td>{{ $item->id_jadwal }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->informasi }}</td>
                    <td>
                        <!-- Tombol Detail -->
                        <a href="{{ route('jadwal.show', $item->id_jadwal) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <!-- Tombol Edit -->
                        <a href="{{ route('jadwal.edit', $item->id_jadwal) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <!-- Tombol Hapus -->
                        <form action="{{ route('jadwal.destroy', $item->id_jadwal) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection