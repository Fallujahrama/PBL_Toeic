@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm border-radius-md bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-users text-white text-sm opacity-10"></i>
                        </div>
                        <h6 class="mb-0">{{ $page->title }}</h6>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm ms-auto">
                            <i class="fas fa-plus me-1"></i> Tambah Pengguna
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success mx-4">
                            <i class="fas fa-check me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger mx-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengguna</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pengguna</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Level</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <i class="fas fa-calendar-day text-info"></i> Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                @if($user->foto_profil)
                                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" class="avatar avatar-sm me-3" alt="user">
                                                @else
                                                    <div class="avatar avatar-sm bg-gradient-secondary me-3 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user text-white text-sm"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->nama ?? 'Nama tidak tersedia' }}</h6>
                                                <p class="text-xs text-secondary mb-0">ID: {{ $user->id_user }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->username }}</p>
                                    </td>
                                    <td>
                                        @if($user->level)
                                            @if($user->level->level_kode == 'SprAdmin')
                                                <span class="badge badge-sm bg-gradient-danger">{{ $user->level->level_nama }}</span>
                                            @elseif($user->level->level_kode == 'AdmUpa')
                                                <span class="badge badge-sm bg-gradient-warning">{{ $user->level->level_nama }}</span>
                                            @elseif($user->level->level_kode == 'AdmITC')
                                                <span class="badge badge-sm bg-gradient-info">{{ $user->level->level_nama }}</span>
                                            @elseif($user->level->level_kode == 'Mhs')
                                                <span class="badge badge-sm bg-gradient-success">{{ $user->level->level_nama }}</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">{{ $user->level->level_nama }}</span>
                                            @endif
                                        @else
                                            <span class="badge badge-sm bg-gradient-secondary">Tidak ada level</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">
                                            <i class="fas fa-calendar-day text-info me-1"></i>
                                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <a href="{{ route('admin.users.show', $user->id_user) }}" class="btn btn-link text-info text-gradient px-2 mb-0" title="Lihat Detail">
                                                <i class="fas fa-eye text-info me-1"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id_user) }}" class="btn btn-link text-warning text-gradient px-2 mb-0" title="Ubah">
                                                <i class="fas fa-edit text-warning me-1"></i>
                                            </a>
                                            <button type="button" class="btn btn-link text-danger text-gradient px-2 mb-0"
                                                    onclick="confirmDelete({{ $user->id_user }}, '{{ $user->nama ?? $user->username }}')" title="Hapus">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-users text-muted mb-2" style="font-size: 3rem;"></i>
                                            <h6 class="text-muted">Belum ada data pengguna</h6>
                                            <p class="text-sm text-muted">Klik tombol "Tambah Pengguna" untuk menambah pengguna baru</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengguna <strong id="userName"></strong>?</p>
                <p class="text-danger text-sm">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function confirmDelete(userId, userName) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('deleteForm').action = '/admin/users/' + userId;

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush
