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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="judul" class="form-control-label">Judul</label>
                                <h5 class="form-control-static">{{ $notifikasi->judul }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal" class="form-control-label">Tanggal</label>
                                <p class="form-control-static">{{ \Carbon\Carbon::parse($notifikasi->created_at)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-control-label">Status</label>
                                <p class="form-control-static">
                                    @if($notifikasi->is_read)
                                        <span class="badge badge-sm bg-gradient-secondary">Dibaca</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-info">Baru</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="isi" class="form-control-label">Isi Notifikasi</label>
                                <div class="p-3 border rounded mt-2" style="white-space: pre-line">
                                    {!! nl2br(e($notifikasi->pesan)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- @if($notifikasi->lampiran_path)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="lampiran" class="form-control-label">Lampiran</label>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $notifikasi->lampiran_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-2"></i> Download Lampiran
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif --}}

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a href="{{ route('mahasiswa.notifikasi.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mark notification as read via AJAX
    document.addEventListener('DOMContentLoaded', function() {
        @if(!$notifikasi->is_read)
        fetch('{{ route("mahasiswa.notifikasi.read", $notifikasi->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        });
        @endif
    });
</script>
@endsection
