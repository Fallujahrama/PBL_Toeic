@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Edit Notifikasi</h1>

    <form action="{{ route('notifications.update', $notification->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $notification->tanggal }}" required>
        </div>
        <div class="form-group">
            <label for="pesan">Pesan</label>
            <textarea name="pesan" id="pesan" class="form-control" rows="3" required>{{ $notification->pesan }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
