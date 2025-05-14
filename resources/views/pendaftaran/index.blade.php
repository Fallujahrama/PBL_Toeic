@extends('layouts.template')

@section('title', 'Daftar Pendaftaran - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pendaftaran</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">Daftar Pendaftaran</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h5 class="mb-0">Daftar Pendaftaran TOEIC</h5>
                    </div>
                    <a href="{{ route('pendaftaran.create') }}" class="btn btn-sm btn-primary" data-aos="fade-left">
                        <i class="fas fa-plus me-2"></i>Tambah Pendaftaran
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
                
                @if (session('error'))
                    <div class="alert alert-danger mx-4 mt-3" role="alert" data-aos="fade-up">
                        <div class="d-flex">
                            <div class="icon icon-shape icon-xs bg-gradient-danger text-white rounded-circle shadow me-2">
                                <i class="fas fa-times"></i>
                            </div>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                <div class="table-responsive p-0 mt-3">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">NIM</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Nama</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Tanggal Daftar</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Dokumen</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $item)
                                <tr class="pendaftaran-row fade-in" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->id_pendaftaran }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-xs bg-gradient-info text-white rounded-circle shadow me-2">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nim }}</p>
                                        </div>
                                    </td>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->mahasiswa->nama ?? 'N/A' }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->created_at->format('d M Y H:i') }}</p>
                                    </td>
                                    <td class="ps-4">
                                        <div class="d-flex">
                                            <a href="{{ asset('storage/' . $item->file_ktp) }}" target="_blank" class="btn btn-link text-primary px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat KTP">
                                                <i class="fas fa-id-card"></i>
                                            </a>
                                            <a href="{{ asset('storage/' . $item->file_ktm) }}" target="_blank" class="btn btn-link text-info px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat KTM">
                                                <i class="fas fa-address-card"></i>
                                            </a>
                                            <a href="{{ asset('storage/' . $item->file_foto) }}" target="_blank" class="btn btn-link text-success px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Foto">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('pendaftaran.show', $item->id_pendaftaran) }}" class="btn btn-link text-info px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pendaftaran.edit', $item->id_pendaftaran) }}" class="btn btn-link text-warning px-2 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link text-danger px-2 mb-0 delete-btn" 
                                                data-id="{{ $item->id_pendaftaran }}" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $pendaftaran->links() }}
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
                Apakah Anda yakin ingin menghapus pendaftaran ini?
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
            $('#deleteForm').attr('action', `{{ url('pendaftaran') }}/${id}`);
            $('#deleteModal').modal('show');
        });
    });
</script>
@endpush
