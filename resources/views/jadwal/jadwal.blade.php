@extends('layout.template')

@section('content')
<div class="container mt-5">
    <h2>Jadwal Ujian TOEIC</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID jadwal</th>
                <th>Tanggal</th>
                <th>Informasi</th>
                <th>File Info</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $item)
            <tr>
                <td>{{ $item->id_jadwal }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->informasi }}</td>
                <td><button class="btn btn-primary btn-sm">Lihat File</button> </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection