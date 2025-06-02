@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Mahasiswa</h3>
        <div class="card-tools">
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-sm btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <a href="{{ route('admin.mahasiswa.edit', $data->nim) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">NIM</th>
                        <td>{{ $data->nim }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>{{ $data->jurusan }}</td>
                    </tr>
                    <tr>
                        <th>Program Studi</th>
                        <td>{{ $data->program_studi }}</td>
                    </tr>
                    <tr>
                        <th>Kampus</th>
                        <td>{{ $data->kampus }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">NIK</th>
                        <td>{{ $data->nik }}</td>
                    </tr>
                    <tr>
                        <th>No WhatsApp</th>
                        <td>{{ $data->no_whatsapp }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Asal</th>
                        <td>{{ $data->alamat_asal }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Saat Ini</th>
                        <td>{{ $data->alamat_saat_ini }}</td>
                    </tr>
                    <tr>
                        <th>Terdaftar Pada</th>
                        <td>{{ $data->created_at ? date('d-m-Y H:i', strtotime($data->created_at)) : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if(isset($data->pendaftaran) && count($data->pendaftaran) > 0)
        <div class="mt-4">
            <h5>Riwayat Pendaftaran</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Jenis Pendaftaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->pendaftaran as $key => $pendaftaran)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ date('d-m-Y H:i', strtotime($pendaftaran->created_at)) }}</td>
                        <td>
                            @if($pendaftaran->status == 'Menunggu Verifikasi')
                                <span class="badge badge-warning">{{ $pendaftaran->status }}</span>
                            @elseif($pendaftaran->status == 'Terverifikasi')
                                <span class="badge badge-success">{{ $pendaftaran->status }}</span>
                            @elseif($pendaftaran->status == 'Ditolak')
                                <span class="badge badge-danger">{{ $pendaftaran->status }}</span>
                            @else
                                <span class="badge badge-secondary">{{ $pendaftaran->status }}</span>
                            @endif
                        </td>
                        <td>{{ $pendaftaran->jenis_pendaftaran }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
