@extends('layouts.template')

@section('content')
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{ route('pendaftaran.lama.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" id="jurusan" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" readonly>
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
                <label for="bukti_pembayaran">Bukti Pembayaran</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="bukti_pembayaran" name="bukti_pembayaran" required>
                    <label class="custom-file-label" for="bukti_pembayaran">Browse file</label>
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

@push('scripts')
<script>
  document.getElementById('nim').addEventListener('blur', function () {
    const nim = this.value.trim();
    if (!nim) return;

    fetch(`/pendaftaran/lama/get-mahasiswa/${encodeURIComponent(nim)}`)
      .then(r => r.json())
      .then(res => {
        if (res.status === 'error') {
          // Munculkan alert kalau NIM tidak ada
          alert(res.message);
        }
        // kalau success, kita abaikan (atau autofill jika sudah diaktifkan)
      })
      .catch(err => {
        console.error(err);
        alert('Gagal memeriksa NIM. Silakan ulangi.');
      });
  });
</script>
@endpush
