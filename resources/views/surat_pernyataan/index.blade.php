<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/pblToeic/resources/views/surat_pernyataan/index.blade.php -->
@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Validasi Surat Pernyataan</h1>
    <p>Berikut adalah daftar surat pernyataan yang diupload oleh mahasiswa.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Jurusan</th>
                <th>Prodi</th>
                <th>Kampus</th>
                <th>File</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suratPernyataan as $item)
                <tr>
                    <td>{{ $item->mahasiswa->nama }}</td>
                    <td>{{ $item->mahasiswa->nim }}</td>
                    <td>{{ $item->mahasiswa->jurusan }}</td>
                    <td>{{ $item->mahasiswa->program_studi }}</td>
                    <td>{{ $item->mahasiswa->kampus }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $item->file_surat_pernyataan) }}" target="_blank" class="btn btn-info btn-sm">Lihat File</a>
                    </td>
                    <td>
                        @if ($item->status == 'valid')
                            <span class="badge badge-success">Valid</span>
                        @elseif ($item->status == 'rejected')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->status == 'pending')
                            <form action="{{ route('surat_pernyataan.validate', $item->id_surat_pernyataan) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Validasi</button>
                            </form>
                            <form action="{{ route('surat_pernyataan.reject', $item->id_surat_pernyataan) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
