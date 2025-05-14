@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Upload Hasil Ujian</h1>
    <form action="{{ route('hasil_ujian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="jadwal_id">Jadwal</label>
            <select name="jadwal_id" id="jadwal_id" class="form-control" required>
                <option value="">Pilih Jadwal</option>
                @foreach ($jadwal as $item)
                    <option value="{{ $item->jadwal_id }}">{{ $item->informasi }} ({{ $item->tanggal }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="file_nilai">File Hasil Ujian</label>
            <input type="file" name="file_nilai" id="file_nilai" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="{{ route('hasil_ujian.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
