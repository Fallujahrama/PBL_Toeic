@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Detail Notifikasi</h1>
    <div class="card">
        <div class="card-header">
            <h3>{{ $notification->tanggal }}</h3>
        </div>
        <div class="card-body">
            <p>{{ $notification->pesan }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
