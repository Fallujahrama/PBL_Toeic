@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Mahasiswa</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <form method="GET" action="{{ url()->current() }}">
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label pt-1">Filter :</label>
                        <div class="col-9">
                            <select class="form-control" id="kampus" name="kampus" onchange="this.form.submit()">
                                <option value="" {{ ($kampusFilter ?? '') == '' ? 'selected' : '' }}>- Semua Kampus -</option>
                                @foreach ($kampus ?? [] as $item)
                                    <option value="{{ $item->kampus }}" {{ ($kampusFilter ?? '') == $item->kampus ? 'selected' : '' }}>
                                        {{ $item->kampus }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kampus</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            
        <table id="mahasiswaTable" class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>
                        Jurusan
                        <select class="filter-select" data-column="2">
                            <option value="">- Semua -</option>
                        </select>
                    </th>
                    <th>
                        Program Studi
                        <select class="filter-select" data-column="3">
                            <option value="">- Semua -</option>
                        </select>
                    </th>
                    <th>Kampus</th>
                    <th>No WhatsApp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $mhs)
                    <tr>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->jurusan }}</td>
                        <td>{{ $mhs->program_studi }}</td>
                        <td>{{ $mhs->kampus }}</td>
                        <td>{{ $mhs->no_whatsapp }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.mahasiswa.show', $mhs->nim) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.mahasiswa.edit', $mhs->nim) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $mhs->nim }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $mhs->nim }}" action="{{ route('admin.mahasiswa.destroy', $mhs->nim) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
<style>
    /* 1. Buat layout tabel fixed dan penuh */
    #mahasiswaTable {
        table-layout: fixed;
        width: 100%;
    }
    /* 2. Pastikan setiap kolom (thead th & tbody td) mengambil lebar yang sesuai */
    #mahasiswaTable thead th,
    #mahasiswaTable tbody td {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    /* 3. Dropdown filter kecil tetap rapih */
    #mahasiswaTable thead th select.filter-select {
        width: 80px;
        font-size: 12px;
        padding: 2px 4px;
        height: 26px;
        margin-left: 4px;
        vertical-align: middle;
    }
    /* 4. Kolom aksi lebih kecil */
    #mahasiswaTable th:last-child,
    #mahasiswaTable td:last-child {
        width: 120px;
    }
    /* 5. Tombol aksi lebih kecil */
    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var table = $('#mahasiswaTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
    });

    // Isi dropdown filter untuk kolom Jurusan dan Program Studi
    table.columns([2,3]).every(function() {
        var column = this;
        var colIndex = column.index();
        var select = $('select.filter-select[data-column="'+colIndex+'"]');
        column.data().unique().sort().each(function(d) {
            if (d) select.append('<option value="'+d+'">'+d+'</option>');
        });
    });

    // Event ketika dropdown filter berubah
    $('select.filter-select').on('change', function() {
        var colIndex = $(this).data('column');
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        table.column(colIndex)
             .search(val ? '^'+val+'$' : '', true, false)
             .draw();
    });
});

function confirmDelete(nim) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data mahasiswa ini akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + nim).submit();
        }
    });
}
</script>
@endpush
