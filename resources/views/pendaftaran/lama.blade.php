@extends('layouts.template')

@section('content')
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
@endsection

@push('scripts')
<script>
    // Autofill data mahasiswa berdasarkan NIM
   document.getElementById('nim').addEventListener('blur', function () {
    const nim = this.value;

    if (nim.length > 0) {
        fetch(`/pendaftaran/lama/get-mahasiswa/${nim}`)
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    const data = result.data;
                    // Autofill form fields with data received from backend
                    document.getElementById('nama').value = data.nama || '';
                    document.getElementById('jurusan').value = data.jurusan || '';
                    document.getElementById('prodi').value = data.prodi || '';
                } else {
                    alert(result.message);  // Inform user if data is not found
                    document.getElementById('nama').value = '';
                    document.getElementById('jurusan').value = '';
                    document.getElementById('prodi').value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});
</script>
@endpush
