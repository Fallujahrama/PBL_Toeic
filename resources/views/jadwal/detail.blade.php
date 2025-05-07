@extends('layout.template')

@section('content')
<div>
    <p><strong>ID Jadwal:</strong> {{ $jadwal->id_jadwal }}</p>
    <p><strong>Tanggal:</strong> {{ $jadwal->tanggal }}</p>
    <p><strong>Nama:</strong> {{ $jadwal->nama }}</p>
    <p><strong>Informasi:</strong> {{ $jadwal->informasi }}</p>
</div>
@endsection