@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Upload Surat Pernyataan</h1>
    <p>Silakan upload surat pernyataan Anda.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('surat_pernyataan.storeMahasiswa') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
        </div>
        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" name="nim" id="nim" class="form-control" value="{{ $mahasiswa->nim }}" readonly>
        </div>
        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ $mahasiswa->jurusan }}" readonly>
        </div>
        <div class="form-group">
            <label for="prodi">Prodi</label>
            <input type="text" name="prodi" id="prodi" class="form-control" value="{{ $mahasiswa->program_studi }}" readonly>
        </div>
        <div class="form-group">
            <label for="kampus">Kampus</label>
            <input type="text" name="kampus" id="kampus" class="form-control" value="{{ $mahasiswa->kampus }}" readonly>
        </div>
        <div class="form-group">
            <label for="file_surat_pernyataan">File Surat Pernyataan</label>
            <input type="file" name="file_surat_pernyataan" id="file_surat_pernyataan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
