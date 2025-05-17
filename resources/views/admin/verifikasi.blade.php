@extends('layout.template')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $breadcrumb['title'] }}</h1>
        <ol class="breadcrumb">
            @foreach($breadcrumb['list'] as $item)
            @if($loop->last)
            <li class="breadcrumb-item active">{{ $item }}</li>
            @else
            <li class="breadcrumb-item">{{ $item }}</li>
            @endif
            @endforeach
        </ol>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftar</h6>
            <div>
                <span class="badge badge-success mr-2">Terverifikasi</span>
                <span class="badge badge-warning mr-2">Menunggu</span>
                <span class="badge badge-danger">Ditolak</span>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarans as $index => $pendaftaran)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pendaftaran->nim }}</td>
                            <td>{{ $pendaftaran->mahasiswa->nama }}</td>
                            <td>{{ $pendaftaran->mahasiswa->jurusan ?? '-' }}</td>
                            <td>
                                @if($pendaftaran->status_verifikasi == 'approved')
                                <span class="badge badge-success">Terverifikasi</span>
                                @elseif($pendaftaran->status_verifikasi == 'rejected')
                                <span class="badge badge-danger">Ditolak</span>
                                @else
                                <span class="badge badge-warning">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.verifikasi.show', $pendaftaran->id_pendaftaran) }}"
                                    class="btn btn-primary btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, .02);
    }
</style>
@endsection