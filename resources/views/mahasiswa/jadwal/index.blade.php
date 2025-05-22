@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    @include('layouts.breadcrumb')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $page->title }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tempat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kuota</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwal as $key => $item)
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
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->tempat }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->kuota }}</p>
                                    </td>
                                    <td>
                                        @php
                                            $now = \Carbon\Carbon::now();
                                            $jadwalDate = \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu_mulai);
                                            $status = $now->gt($jadwalDate) ? 'Selesai' : 'Akan Datang';
                                            $badgeClass = $now->gt($jadwalDate) ? 'bg-gradient-secondary' : 'bg-gradient-success';
                                        @endphp
                                        <span class="badge badge-sm {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('mahasiswa.jadwal.show', ['id' => $item->jadwal_id]) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Detail jadwal">
                                            Detail
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
    </div>
</div>
@endsection
