@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Jadwal Kegiatan Mahasiswa</h1>
    <p>Berikut adalah jadwal kegiatan mahasiswa yang telah terdaftar.</p>
    <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Jadwal</th>
                <th>Tanggal</th>
                <th>Informasi</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $item)
                <tr>
                    <td>{{ $item->jadwal_id }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->informasi }}</td>
                    <td>
                        @if ($item->file_info)
                            <a href="{{ asset('storage/' . $item->file_info) }}" target="_blank" class="btn btn-info btn-sm">Lihat File</a>
                        @else
                            Tidak ada file
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('jadwal.edit', $item->jadwal_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jadwal.destroy', $item->jadwal_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
