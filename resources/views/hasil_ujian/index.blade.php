@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Daftar Hasil Ujian</h1>
    <a href="{{ route('hasil_ujian.create') }}" class="btn btn-primary mb-3">Upload Hasil Ujian</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Hasil</th>
                <th>Tanggal</th>
                <th>Jadwal</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilUjian as $item)
                <tr>
                    <td>{{ $item->id_hasil }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jadwal->informasi }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $item->file_nilai) }}" target="_blank" class="btn btn-info btn-sm">Lihat File</a>
                    </td>
                    <td>
                        <form action="{{ route('hasil_ujian.destroy', $item->id_hasil) }}" method="POST" style="display:inline;">
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
