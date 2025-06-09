@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-background shadow-lg border-radius-xl">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8 text-center text-lg-start">
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                                <div class="icon icon-shape bg-white text-primary rounded-circle shadow me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="text-white mb-1">Data Mahasiswa</h3>
                                    <p class="text-white opacity-8 mb-0">Kelola dan pantau data mahasiswa TOEIC</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                            <div class="d-inline-flex align-items-center bg-white rounded-circle p-3 shadow">
                                <div class="text-center">
                                    <h4 class="mb-0 text-primary">{{ $data->count() }}</h4>
                                    <small class="text-muted">Total Mahasiswa</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-background-overlay"></div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        @php
            $totalMahasiswa = $data->count();
            $kampusStats = $data->groupBy('kampus')->map->count();
            $jurusanStats = $data->groupBy('jurusan')->map->count();
        @endphp

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Mahasiswa</p>
                                <h5 class="font-weight-bolder">{{ $totalMahasiswa }}</h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">Aktif</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-circle bg-gradient-primary">
                                <i class="fas fa-users text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Kampus</p>
                                <h5 class="font-weight-bolder">{{ $kampusStats->count() }}</h5>
                                <p class="mb-0">
                                    <span class="text-info text-sm font-weight-bolder">Lokasi</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-circle bg-gradient-success">
                                <i class="fas fa-university text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Jurusan</p>
                                <h5 class="font-weight-bolder">{{ $jurusanStats->count() }}</h5>
                                <p class="mb-0">
                                    <span class="text-warning text-sm font-weight-bolder">Program</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-circle bg-gradient-warning">
                                <i class="fas fa-book text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Kampus Terbanyak</p>
                                <h5 class="font-weight-bolder">{{ $kampusStats->keys()->first() ?? 'N/A' }}</h5>
                                <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder">{{ $kampusStats->max() ?? 0 }} mahasiswa</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon-circle bg-gradient-info">
                                <i class="fas fa-chart-bar text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h6 class="text-white mb-0">
                                <i class="fas fa-table me-2"></i>Daftar Mahasiswa
                            </h6>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button class="btn btn-outline-white btn-sm" onclick="exportData()">
                                <i class="fas fa-download me-2"></i>Export Data
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Advanced Filters -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label text-sm font-weight-bold">Filter Kampus</label>
                                <form method="GET" action="{{ url()->current() }}">
                                    <select class="form-select" id="kampus" name="kampus" onchange="this.form.submit()">
                                        <option value="" {{ ($kampusFilter ?? '') == '' ? 'selected' : '' }}>
                                            <i class="fas fa-university"></i> Semua Kampus
                                        </option>
                                        @foreach ($kampus ?? [] as $item)
                                            <option value="{{ $item->kampus }}" {{ ($kampusFilter ?? '') == $item->kampus ? 'selected' : '' }}>
                                                {{ $item->kampus }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label text-sm font-weight-bold">Pencarian Cepat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="quickSearch" placeholder="Cari nama atau NIM...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label text-sm font-weight-bold">Tampilkan</label>
                                <select class="form-select" id="pageLength">
                                    <option value="10">10 data</option>
                                    <option value="25">25 data</option>
                                    <option value="50">50 data</option>
                                    <option value="-1">Semua data</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Data Table -->
                    <div class="table-responsive">
                        <table id="mahasiswaTable" class="table table-hover align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <i class="fas fa-id-card me-1"></i>NIM
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <i class="fas fa-user me-1"></i>Mahasiswa
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <i class="fas fa-book me-1"></i>Jurusan
                                        <select class="filter-select ms-2" data-column="2">
                                            <option value="">Semua</option>
                                        </select>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <i class="fas fa-graduation-cap me-1"></i>Program Studi
                                        <select class="filter-select ms-2" data-column="3">
                                            <option value="">Semua</option>
                                        </select>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <i class="fas fa-university me-1"></i>Kampus
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $mhs)
                                    <tr class="mahasiswa-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-gradient-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <span class="text-white text-xs font-weight-bold">
                                                        {{ substr($mhs->nim, -2) }}
                                                    </span>
                                                </div>
                                                <span class="text-sm font-weight-bold">{{ $mhs->nim }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $mhs->nama }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fas fa-id-badge me-1"></i>NIK: {{ $mhs->nik ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">{{ $mhs->jurusan }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $mhs->program_studi }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-xs bg-gradient-success rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-university text-white"></i>
                                                </div>
                                                <span class="text-sm font-weight-bold">{{ $mhs->kampus }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($mhs->no_whatsapp)
                                                <a href="https://wa.me/62{{ $mhs->no_whatsapp }}" target="_blank"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fab fa-whatsapp me-1"></i>{{ $mhs->no_whatsapp }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />
<style>
    .card-background {
        background: linear-gradient(310deg, #2c3e88 0%, #1a2c6b 100%);
        position: relative;
        overflow: hidden;
    }

    .card-background-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.3;
        pointer-events: none;
    }

    .animate-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .animate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    #mahasiswaTable {
        border-radius: 10px;
        overflow: hidden;
    }

    #mahasiswaTable thead th {
        background: linear-gradient(310deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        padding: 15px 10px;
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    #mahasiswaTable tbody tr {
        border-bottom: 1px solid #f0f2f5;
        transition: all 0.3s ease;
    }

    #mahasiswaTable tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .filter-select {
        width: 80px;
        font-size: 10px;
        padding: 2px 4px;
        height: 24px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: white;
    }

    .btn-group .btn {
        margin: 0 1px;
        border-radius: 6px !important;
        padding: 6px 10px;
        font-size: 12px;
    }

    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }

    .badge {
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 8px;
    }

    .mahasiswa-row {
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-select, .form-control {
        border-radius: 8px;
        border: 1px solid #e0e6ed;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-select:focus, .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.25);
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e0e6ed;
        border-right: none;
        border-radius: 8px 0 0 8px;
    }

    .btn-outline-white {
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        transition: all 0.3s ease;
    }

    .btn-outline-white:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: white;
        color: white;
    }

    /* New styles for better icon centering */
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: auto;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .icon-circle i {
        font-size: 20px;
        color: white;
    }
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable with enhanced features
    var table = $('#mahasiswaTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 10,
        "order": [[1, "asc"]],
        "language": {
            "search": "",
            "searchPlaceholder": "Cari data...",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        },
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip',
        "drawCallback": function() {
            // Animate rows
            $('.mahasiswa-row').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    // Custom search functionality
    $('#quickSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Page length change
    $('#pageLength').on('change', function() {
        table.page.len(this.value).draw();
    });

    // Populate filter dropdowns
    table.columns([2,3]).every(function() {
        var column = this;
        var colIndex = column.index();
        var select = $('select.filter-select[data-column="'+colIndex+'"]');

        column.data().unique().sort().each(function(d) {
            if (d) {
                select.append('<option value="'+d+'">'+d+'</option>');
            }
        });
    });

    // Filter dropdown change events
    $('select.filter-select').on('change', function() {
        var colIndex = $(this).data('column');
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        table.column(colIndex)
             .search(val ? '^'+val+'$' : '', true, false)
             .draw();
    });
});

// Export data function
function exportData() {
    Swal.fire({
        title: 'Export Data',
        text: 'Pilih format export yang diinginkan',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Excel',
        cancelButtonText: 'PDF',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Export to Excel
            window.location.href = '/admin/mahasiswa/export/excel';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Export to PDF
            window.location.href = '/admin/mahasiswa/export/pdf';
        }
    });
}

// Initialize tooltips
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush
