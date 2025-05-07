@extends('layout.template')

@section('content')
<div class="container mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">

    </nav>

    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Jadwal Ujian Mahasiswa</h2>
        <p class="text-muted">Berikut adalah jadwal ujian mahasiswa yang telah terdaftar.</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID Jadwal</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Informasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $item)
                <tr id="row-{{ $item->id_jadwal }}">
                    <td>{{ $item->id_jadwal }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->informasi }}</td>
                    <td>
                        <!-- Tombol Detail -->
                        <a href="{{ route('jadwal.show', $item->id_jadwal) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <!-- Tombol Edit -->
                        <a href="{{ route('jadwal.edit', $item->id_jadwal) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <!-- Tombol Hapus -->
                        <form action="{{ route('jadwal.destroy', $item->id_jadwal) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal untuk Detail dan Edit -->
<div class="modal fade" id="modalJadwal" tabindex="-1" aria-labelledby="modalJadwalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJadwalLabel">Detail Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Konten akan diisi melalui AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Detail Jadwal
        $('.btn-detail').click(function() {
            const id = $(this).data('id');
            $.ajax({
                url: `/jadwal/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#modalJadwal .modal-title').text('Detail Jadwal');
                    $('#modalJadwal .modal-body').html(response);
                    $('#modalJadwal').modal('show');
                },
                error: function() {
                    alert('Gagal mengambil data detail.');
                }
            });
        });

        // Edit Jadwal
        $('.btn-edit').click(function() {
            const id = $(this).data('id');
            $.ajax({
                url: `/jadwal/${id}/edit`,
                type: 'GET',
                success: function(response) {
                    $('#modalJadwal .modal-title').text('Edit Jadwal');
                    $('#modalJadwal .modal-body').html(response);
                    $('#modalJadwal').modal('show');
                },
                error: function() {
                    alert('Gagal mengambil data untuk edit.');
                }
            });
        });

        // Hapus Jadwal
        $('.btn-delete').click(function() {
            const id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `/jadwal/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        $(`#row-${id}`).remove();
                        alert('Data berhasil dihapus.');
                    },
                    error: function() {
                        alert('Gagal menghapus data.');
                    }
                });
            }
        });
    });
</script>
@endsection