@extends('layouts.template')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('pendaftaran.storeBaru') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" required>
            </div>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik" class="form-control" required>
            </div>

            <div class="form-group">
                <label>No. WA</label>
                <input type="text" name="wa" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Alamat Asal</label>
                <textarea name="alamat_asal" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Alamat Sekarang</label>
                <textarea name="alamat_sekarang" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" name="prodi" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kampus</label>
                <select name="kampus" class="form-control" required>
                    <option value="">-- Pilih Kampus --</option>
                    <option value="Utama">Utama</option>
                    <option value="PSDKU Kediri">PSDKU Kediri</option>
                    <option value="PSDKU Lumajang">PSDKU Lumajang</option>
                    <option value="PSDKU Pamekasan">PSDKU Pamekasan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ktp">Scan KTP</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="ktp" name="ktp" required>
                    <label class="custom-file-label" for="ktp">Browse file</label>
                </div>
            </div>

            <div class="form-group">
                <label for="scan_ktm">Scan KTM</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="scan_ktm" name="scan_ktm" required>
                    <label class="custom-file-label" for="scan_ktm">Browse file</label>
                </div>
            </div>

            <div class="form-group">
                <label for="pas_foto">Pas Foto Terbaru</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="pas_foto" name="pas_foto" required>
                    <label class="custom-file-label" for="pas_foto">Browse file</label>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ url('pendaftaran') }}" class="btn btn-secondary ml-2">Back</a>
            </div>

        </form>
    </div>
</div>

<script>
    // Update label setiap file input
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name || 'Browse file';
            e.target.nextElementSibling.innerText = fileName;
        });
    });
</script>

@endsection
