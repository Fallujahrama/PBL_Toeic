@extends('layouts.template')

@section('title', 'Daftar Hasil Ujian - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Hasil Ujian</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Daftar Hasil Ujian</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-success text-white rounded-circle shadow me-2">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5 class="mb-0">Daftar Hasil Ujian TOEIC</h5>
                    </div>
                    <a href="{{ route('hasil_ujian.create') }}" class="btn btn-sm btn-primary" data-aos="fade-left">
                        <i class="fas fa-plus me-2"></i>Upload Hasil Ujian
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success mx-4 mt-3" role="alert" data-aos="fade-up">
                        <div class="d-flex">
                            <div class="icon icon-shape icon-xs bg-gradient-success text-white rounded-circle shadow me-2">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                <div class="table-responsive p-0 mt-3">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Jadwal</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">File</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilUjian as $item)
                                <tr class="hasil-row fade-in" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-xs bg-gradient-info text-white rounded-circle shadow me-2">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                            <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                                        </div>
                                    </td>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->jadwal->informasi }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <a href="{{ asset('storage/' . $item->file_nilai) }}" target="_blank" class="btn btn-link text-info px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat File">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                    <td class="align-middle text-center">
                                        <form action="{{ route('hasil_ujian.destroy', $item->id_hasil) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-link text-danger px-2 mb-0 delete-btn" 
                                                data-id="{{ $item->id_hasil }}" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus hasil ujian ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .hasil-row {
        transition: all 0.3s ease;
    }
    
    .hasil-row:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Delete confirmation
        $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            $('#deleteForm').attr('action', `{{ url('hasil_ujian') }}/${id}`);
            $('#deleteModal').modal('show');
        });
    });
</script>
@endpush
