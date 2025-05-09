@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Daftar Notifikasi</h1>
    <a href="{{ route('notifications.create') }}" class="btn btn-primary mb-3">Tambah Notifikasi</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pesan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr>
                    <td>{{ $notification->id }}</td>
                    <td>{{ $notification->tanggal }}</td>
                    <td>{{ $notification->pesan }}</td>
                    <td>
                        <a href="{{ route('notifications.show', $notification->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display:inline;">
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
