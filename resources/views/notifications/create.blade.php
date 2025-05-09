@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Tambah Notifikasi</h1>

    <form action="{{ route('notifications.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pesan">Pesan</label>
            <textarea name="pesan" id="pesan" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
