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
                        <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $item->id_jadwal }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
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

<!-- Modal untuk Edit -->
<div class="modal fade" id="modalEditJadwal" tabindex="-1" aria-labelledby="modalEditJadwalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditJadwalLabel">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Konten form edit akan dimuat melalui AJAX -->
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
    const id = $(this).data('id'); // Ambil ID jadwal dari atribut data-id
    $.ajax({
        url: `/jadwal/${id}/edit`, // Endpoint untuk mendapatkan form edit
        type: 'GET',
        success: function(response) {
            // Masukkan konten form edit ke dalam modal
            $('#modalEditJadwal .modal-body').html(response);
            // Tampilkan modal
            $('#modalEditJadwal').modal('show');
        },
        error: function() {
            alert('Gagal memuat form edit.');
        }
    });
});

// Submit Form Edit
$(document).on('submit', '#form-edit-jadwal', function(e) {
    e.preventDefault(); // Mencegah reload halaman
    const form = $(this);
    const actionUrl = form.attr('action'); // URL dari atribut action form
    const formData = form.serialize(); // Serialisasi data form

    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: formData,
        success: function(response) {
            alert('Data berhasil diperbarui!');
            $('#modalEditJadwal').modal('hide'); // Tutup modal
            location.reload(); // Reload halaman untuk memperbarui data
        },
        error: function() {
            alert('Gagal memperbarui data.');
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