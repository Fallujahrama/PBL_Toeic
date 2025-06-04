@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    @include('layouts.breadcrumb')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Hasil Ujian TOEIC</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if($hasil_ujian->isEmpty())
                        <div class="text-center p-4">
                            <p>Belum ada hasil ujian TOEIC saat ini</p>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Informasi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">File</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hasil_ujian as $key => $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $key + 1 }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">Hasil Ujian TOEIC</p>
                                        </td>
                                        <td>
                                            @if($item->file_nilai)
                                                @php
                                                    $extension = pathinfo($item->file_nilai, PATHINFO_EXTENSION);
                                                @endphp
                                                <span class="badge bg-primary text-white">
                                                    <i class="fas fa-file me-1"></i>{{ strtoupper($extension) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Tidak ada file</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if($item->file_nilai)
                                                <a href="{{ asset('storage/' . $item->file_nilai) }}" class="btn btn-link text-info px-2 mb-0" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview File">
                                                    <i class="fas fa-eye"></i> Preview
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
