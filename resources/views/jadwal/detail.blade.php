    <!-- Detail Jadwal -->
    <div>
        <p><strong>ID Jadwal:</strong> {{ $jadwal->id_jadwal }}</p>
        <p><strong>Tanggal:</strong> {{ $jadwal->tanggal }}</p>
        <p><strong>Nama:</strong> {{ $jadwal->nama }}</p>
        <p><strong>Informasi:</strong> {{ $jadwal->informasi }}</p>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
