@extends('layouts.template')

@section('title', 'Detail Pendaftaran - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/verifikasi') }}">Verifikasi</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $page->title ?? 'Detail Pendaftaran' }}</h6>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-info text-white rounded-circle shadow me-2">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="mb-0">Data Mahasiswa</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center" data-aos="fade-right" data-aos-delay="100">
                        <div class="profile-image-container mb-4">
                            @if($pendaftaran->file_foto)
                                <img src="{{ asset('storage/' . $pendaftaran->file_foto) }}" class="profile-image" alt="Foto Mahasiswa">
                            @else
                                <div class="profile-image-placeholder">
                                    <i class="fas fa-user fa-4x"></i>
                                </div>
                            @endif
                        </div>
                        <h6 class="mb-1">{{ $pendaftaran->mahasiswa->nama ?? 'Nama tidak tersedia' }}</h6>
                        <p class="text-muted mb-0">{{ $pendaftaran->nim }}</p>
                    </div>

                    <div class="col-md-9" data-aos="fade-left" data-aos-delay="200">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label"><i class="fas fa-id-card me-2"></i>NIK</div>
                                    <div class="info-value">{{ $pendaftaran->mahasiswa->nik ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label"><i class="fas fa-phone me-2"></i>No. WhatsApp</div>
                                    <div class="info-value">{{ $pendaftaran->mahasiswa->no_whatsapp ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label"><i class="fas fa-graduation-cap me-2"></i>Program Studi</div>
                                    <div class="info-value">{{ $pendaftaran->mahasiswa->program_studi ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label"><i class="fas fa-book me-2"></i>Jurusan</div>
                                    <div class="info-value">{{ $pendaftaran->mahasiswa->jurusan ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label"><i class="fas fa-university me-2"></i>Kampus</div>
                                    <div class="info-value">{{ $pendaftaran->mahasiswa->kampus ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label"><i class="fas fa-calendar me-2"></i>Tanggal Daftar</div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <div class="info-label"><i class="fas fa-home me-2"></i>Alamat</div>
                                    <div class="info-value">{{ $pendaftaran->mahasiswa->alamat_saat_ini ?? 'Data tidak tersedia' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card animate-card h-100" data-aos="fade-up" data-aos-delay="300">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-warning text-white rounded-circle shadow me-2">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h5 class="mb-0">Dokumen Pendaftaran</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="document-list">
                    @if($pendaftaran->file_ktp)
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="document-info">
                            <h6>KTP</h6>
                            <p class="text-muted mb-0">Kartu Tanda Penduduk</p>
                        </div>
                        <div class="document-actions">
                            <a href="{{ route('dokumen.preview', ['id' => $pendaftaran->id_pendaftaran, 'jenis' => 'ktp']) }}"
                            class="btn btn-sm btn-info" target="_blank" data-bs-toggle="tooltip" title="Preview File">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/verifikasi/' . $pendaftaran->id_pendaftaran . '/download/ktp') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($pendaftaran->file_ktm)
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="fas fa-address-card"></i>
                        </div>
                        <div class="document-info">
                            <h6>KTM</h6>
                            <p class="text-muted mb-0">Kartu Tanda Mahasiswa</p>
                        </div>
                        <div class="document-actions">
                            <a href="{{ route('dokumen.preview', ['id' => $pendaftaran->id_pendaftaran, 'jenis' => 'ktm']) }}"
                            class="btn btn-sm btn-info" target="_blank" data-bs-toggle="tooltip" title="Preview File">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/verifikasi/' . $pendaftaran->id_pendaftaran . '/download/ktm') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($pendaftaran->file_foto)
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="document-info">
                            <h6>Pas Foto</h6>
                            <p class="text-muted mb-0">Foto Formal Terbaru</p>
                        </div>
                        <div class="document-actions">
                            <a href="{{ route('dokumen.preview', ['id' => $pendaftaran->id_pendaftaran, 'jenis' => 'foto']) }}"
                            class="btn btn-sm btn-info" target="_blank" data-bs-toggle="tooltip" title="Preview File">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/verifikasi/' . $pendaftaran->id_pendaftaran . '/download/foto') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($pendaftaran->file_bukti_pembayaran)
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="document-info">
                            <h6>Bukti Pembayaran</h6>
                            <p class="text-muted mb-0">Bukti Transfer Biaya Pendaftaran</p>
                        </div>
                        <div class="document-actions">
                            <a href="{{ route('dokumen.preview', ['id' => $pendaftaran->id_pendaftaran, 'jenis' => 'bukti']) }}"
                            class="btn btn-sm btn-info" target="_blank" data-bs-toggle="tooltip" title="Preview File">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/verifikasi/' . $pendaftaran->id_pendaftaran . '/download/bukti') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if(!$pendaftaran->file_ktp && !$pendaftaran->file_ktm && !$pendaftaran->file_foto && !$pendaftaran->file_bukti_pembayaran)
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Tidak ada dokumen yang tersedia</h6>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card animate-card h-100" data-aos="fade-up" data-aos-delay="400">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm bg-gradient-success text-white rounded-circle shadow me-2">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5 class="mb-0">Verifikasi Pendaftaran</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('/verifikasi/' . $pendaftaran->id_pendaftaran . '/verify') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Status Verifikasi</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-pending" value="pending" {{ ($pendaftaran->status_verifikasi == 'pending' || !$pendaftaran->status_verifikasi) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-pending">
                                    <span class="badge bg-gradient-warning">Menunggu</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-approved" value="approved" {{ $pendaftaran->status_verifikasi == 'approved' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-approved">
                                    <span class="badge bg-gradient-success">Disetujui</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-rejected" value="rejected" {{ $pendaftaran->status_verifikasi == 'rejected' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-rejected">
                                    <span class="badge bg-gradient-danger">Ditolak</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Tambahkan catatan atau alasan verifikasi (opsional)">{{ $pendaftaran->keterangan }}</textarea>
                    </div>

                    <div class="verification-status-box mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="status-icon me-2">
                                @if($pendaftaran->status_verifikasi == 'approved')
                                    <i class="fas fa-check-circle text-success"></i>
                                @elseif($pendaftaran->status_verifikasi == 'rejected')
                                    <i class="fas fa-times-circle text-danger"></i>
                                @else
                                    <i class="fas fa-clock text-warning"></i>
                                @endif
                            </div>
                            <div class="status-info">
                                <h6 class="mb-0">
                                    @if($pendaftaran->status_verifikasi == 'approved')
                                        Pendaftaran Disetujui
                                    @elseif($pendaftaran->status_verifikasi == 'rejected')
                                        Pendaftaran Ditolak
                                    @else
                                        Menunggu Verifikasi
                                    @endif
                                </h6>
                                <p class="text-muted mb-0">
                                    @if($pendaftaran->updated_at)
                                        Terakhir diperbarui: {{ \Carbon\Carbon::parse($pendaftaran->updated_at)->format('d M Y H:i') }}
                                    @else
                                        Belum diverifikasi
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($pendaftaran->keterangan)
                            <div class="status-note mt-2 p-2 bg-light rounded">
                                <small class="text-muted">{{ $pendaftaran->keterangan }}</small>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ url('/verifikasi') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('verifikasi.edit', $pendaftaran->id_pendaftaran) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Simpan Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pendaftaran ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="{{ route('verifikasi.destroy', $pendaftaran->id_pendaftaran) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .profile-image-container {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
        color: #adb5bd;
        border-radius: 50%;
    }

    .info-item {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }

    .info-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 0.9rem;
    }

    .verification-status-box {
        padding: 15px;
        border-radius: 10px;
        background-color: rgba(0, 0, 0, 0.02);
    }

    .status-icon i {
        font-size: 1.5rem;
    }

    .document-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .document-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 10px;
        background-color: rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .document-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .document-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #6c757d;
    }

    .document-info {
        flex: 1;
    }

    .document-actions {
        display: flex;
        gap: 5px;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Change the background color of the verification status box based on the selected status
        $('input[name="status"]').change(function() {
            const status = $(this).val();
            const statusBox = $('.verification-status-box');
            const statusIcon = $('.status-icon i');
            const statusTitle = $('.status-info h6');

            statusBox.removeClass('bg-light-success bg-light-danger bg-light-warning');

            if (status === 'approved') {
                statusBox.addClass('bg-light-success');
                statusIcon.removeClass('fa-times-circle fa-clock').addClass('fa-check-circle');
                statusIcon.removeClass('text-danger text-warning').addClass('text-success');
                statusTitle.text('Pendaftaran Disetujui');
            } else if (status === 'rejected') {
                statusBox.addClass('bg-light-danger');
                statusIcon.removeClass('fa-check-circle fa-clock').addClass('fa-times-circle');
                statusIcon.removeClass('text-success text-warning').addClass('text-danger');
                statusTitle.text('Pendaftaran Ditolak');
            } else {
                statusBox.addClass('bg-light-warning');
                statusIcon.removeClass('fa-check-circle fa-times-circle').addClass('fa-clock');
                statusIcon.removeClass('text-success text-danger').addClass('text-warning');
                statusTitle.text('Menunggu Verifikasi');
            }
        });
    });
</script>
@endpush
