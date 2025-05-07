@extends('layout.template')

@section('content')
<div class="container mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded">
            @foreach ($breadcrumb->list as $key => $item)
                @if ($key < count($breadcrumb->list) - 1)
                    <li class="breadcrumb-item">
                        <a href="#" class="text-decoration-none text-primary">{{ $item }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active text-dark" aria-current="page">{{ $item }}</li>
                @endif
            @endforeach
        </ol>
    </nav>

    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">{{ $breadcrumb->title }}</h2>
        <p class="text-muted">Berikut adalah jadwal ujian Anda.</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID Jadwal</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Informasi</th>
                    <th>File Info</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwalMahasiswa as $item)
                <tr>
                    <td>{{ $item->id_jadwal }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->informasi }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $item->file_info) }}" class="btn btn-primary btn-sm" target="_blank">
                            <i class="bi bi-file-earmark-text"></i> Lihat File
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada jadwal tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection