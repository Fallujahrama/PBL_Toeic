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
                    @if($hasil_ujian->isEmpty())
                        <div class="text-center p-4">
                            <p>Anda belum memiliki hasil ujian TOEIC.</p>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Ujian</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Skor</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Listening</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Reading</th>
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
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->skor_total ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->skor_listening ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->skor_reading ?? 'N/A' }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('mahasiswa.hasil_ujian.show', $item->id_hasil) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Detail hasil">
                                                Detail
                                            </a>
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
