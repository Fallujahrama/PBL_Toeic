<!-- filepath: resources/views/jadwal/jadwal.blade.php -->
@extends('layout.template')
@section('content')
<div class="card mt-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Daftar Jadwal TOEIC</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>TANGGAL</th>
                        <th>INFORMASI</th>
                        <th>FILE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>
                            <span class="text-info fw-bold">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</span>
                        </td>
                        <td><span class="fw-bold">{{ $item->informasi }}</span></td>
                        <td>
                            @if($item->file_info)
                                <a href="{{ asset($item->file_info) }}" class="btn btn-link text-light" download>
                                    <i class="bi bi-file-earmark-lock2"></i> Download
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('jadwal.show', $item->jadwal_id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <a href="{{ route('jadwal.edit', $item->jadwal_id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('jadwal.destroy', $item->jadwal_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data jadwal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection