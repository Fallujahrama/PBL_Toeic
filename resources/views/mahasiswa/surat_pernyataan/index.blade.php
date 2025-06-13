@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $page->title ?? 'Surat Pernyataan TOEIC' }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container-fluid">
                        {{-- Alert sukses --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card card-primary shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-paper-plane me-2"></i>Ajukan Surat Pernyataan TOEIC</h3>
                            </div>
                            <div class="card-body">
                                @if ($surat)
                                    <div class="alert alert-info">
                                        <strong>Status Dokumen:</strong>
                                        @if($surat->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Validasi</span>
                                        @elseif($surat->status == 'valid')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($surat->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </div>

                                    <div>
                                        <p>Surat pernyataan Anda telah diajukan pada: {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y H:i') }}</p>

                                        @if($surat->status == 'valid' && $surat->file_surat_pernyataan)
                                            <div class="mb-4">
                                                <p>Surat pernyataan Anda telah divalidasi. Silakan lihat berkas berikut:</p>

                                                <div class="d-flex gap-2">
                                                    <a href="{{ url('/mahasiswa/surat-pernyataan/preview/'.$surat->id_surat_pernyataan) }}"
                                                       target="_blank" class="btn btn-info">
                                                        <i class="fas fa-eye me-1"></i> Pratinjau Dokumen
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Form Upload Lampiran -->
                                        <div class="card mb-4 border">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title mb-0"><i class="fas fa-file-upload me-2"></i>Bukti Mengikuti Ujian 2x</h5>
                                            </div>
                                            <div class="card-body">
                                                @if($surat->file_lampiran)
                                                    <div class="mb-3">
                                                        <div class="alert alert-success">
                                                            <i class="fas fa-check-circle me-1"></i> Anda telah mengunggah berkas lampiran

                                                            {{-- Tambahkan badge validasi jika sudah divalidasi --}}
                                                            @if($surat->status == 'valid')
                                                                <span class="badge bg-success ms-2">Tervalidasi</span>
                                                            @endif
                                                        </div>

                                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                                            <a href="{{ url('/mahasiswa/surat-pernyataan/preview-lampiran/'.$surat->id_surat_pernyataan) }}"
                                                               target="_blank" class="btn btn-info">
                                                                <i class="fas fa-eye me-1"></i> Pratinjau Lampiran
                                                            </a>

                                                            {{-- Tampilkan tombol hapus hanya jika status belum divalidasi --}}
                                                            @if($surat->status != 'valid')
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusLampiranModal">
                                                                    <i class="fas fa-trash me-1"></i> Hapus Lampiran
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Anda harus mengunggah bukti telah mengikuti ujian TOEIC sebanyak 2 kali
                                                    </div>

                                                    <form action="{{ route('mahasiswa.surat-pernyataan.upload-lampiran', $surat->id_surat_pernyataan) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="file_lampiran" class="form-label">Pilih Berkas</label>
                                                            <input type="file" class="form-control" id="file_lampiran" name="file_lampiran" accept=".pdf,.jpg,.jpeg,.png" required>
                                                            <div class="form-text">Format yang diterima: PDF, JPG, JPEG, PNG (Maks. 5MB)</div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-upload me-1"></i> Unggah Lampiran
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        @if($surat->status == 'rejected')
                                            <div class="alert alert-warning">
                                                <p class="mb-0">Surat pernyataan Anda ditolak. Silakan ajukan kembali.</p>
                                            </div>
                                            <form action="{{ route('mahasiswa.surat-pernyataan.ajukan') }}" method="POST" class="mt-3">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i> Ajukan Kembali
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <p class="mb-0">Anda belum mengajukan surat pernyataan TOEIC.</p>
                                    </div>

                                    <!-- Form Upload Lampiran untuk mahasiswa yang belum mengajukan surat -->
                                    <div class="card mb-4 border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fas fa-file-upload me-2"></i>Bukti Mengikuti Ujian 2x</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Sebelum mengajukan surat pernyataan, Anda harus mengunggah bukti telah mengikuti ujian TOEIC sebanyak 2 kali.
                                            </div>

                                            <div id="uploadLampiranSection">
                                                <form action="{{ route('mahasiswa.surat-pernyataan.upload-temp-lampiran') }}" method="POST" enctype="multipart/form-data" id="uploadLampiranForm">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="temp_file_lampiran" class="form-label">Pilih Berkas</label>
                                                        <input type="file" class="form-control" id="temp_file_lampiran" name="temp_file_lampiran" accept=".pdf,.jpg,.jpeg,.png" required>
                                                        <div class="form-text">Format yang diterima: PDF, JPG, JPEG, PNG (Maks. 5MB)</div>
                                                    </div>
                                                    <button type="button" id="uploadLampiranBtn" class="btn btn-primary">
                                                        <i class="fas fa-upload me-1"></i> Unggah Lampiran
                                                    </button>
                                                </form>
                                            </div>

                                            <div id="uploadSuccessSection" class="mt-3 d-none">
                                                <div class="alert alert-success">
                                                    <i class="fas fa-check-circle me-1"></i> Berkas lampiran berhasil diunggah. Anda dapat mengajukan surat pernyataan sekarang.
                                                </div>

                                                <div class="d-flex gap-2 mt-3">
                                                    <button type="button" id="changeFileBtn" class="btn btn-outline-secondary">
                                                        <i class="fas fa-sync-alt me-1"></i> Ganti Berkas
                                                    </button>

                                                    <form action="{{ route('mahasiswa.surat-pernyataan.ajukan') }}" method="POST" class="ml-auto" id="ajukanForm">
                                                        @csrf
                                                        <input type="hidden" name="has_uploaded_lampiran" value="1">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-paper-plane me-1"></i> Ajukan Surat Pernyataan
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Lampiran -->
<div class="modal fade" id="hapusLampiranModal" tabindex="-1" aria-labelledby="hapusLampiranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusLampiranModalLabel">Konfirmasi Hapus Lampiran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-warning fs-1"></i>
                </div>
                <p>Apakah Anda yakin ingin menghapus berkas lampiran? Anda perlu mengunggah ulang berkas lampiran setelah menghapusnya.</p>

                {{-- Informasi tambahan tentang penghapusan --}}
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> <strong>Catatan:</strong> Lampiran yang sudah divalidasi admin tidak dapat dihapus.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('mahasiswa.surat-pernyataan.hapus-lampiran', $surat->id_surat_pernyataan ?? 0) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Lampiran</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.document-preview {
    border: 1px dashed #ccc;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    text-align: center;
    background-color: #f8f9fa;
}
</style>
@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handler untuk file input yang sudah ada
        const fileInput = document.getElementById('file_lampiran');
        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                validateFileSize(event.target);
            });
        }

        // Handler untuk form upload lampiran sebelum ajukan
        const tempFileInput = document.getElementById('temp_file_lampiran');
        const uploadLampiranBtn = document.getElementById('uploadLampiranBtn');
        const uploadLampiranForm = document.getElementById('uploadLampiranForm');
        const uploadLampiranSection = document.getElementById('uploadLampiranSection');
        const uploadSuccessSection = document.getElementById('uploadSuccessSection');
        const changeFileBtn = document.getElementById('changeFileBtn');

        if (tempFileInput && uploadLampiranBtn) {
            tempFileInput.addEventListener('change', function(event) {
                validateFileSize(event.target);
            });

            uploadLampiranBtn.addEventListener('click', function() {
                if (tempFileInput.files.length === 0) {
                    alert('Silakan pilih berkas terlebih dahulu.');
                    return;
                }

                // Tampilkan indikator loading
                uploadLampiranBtn.disabled = true;
                uploadLampiranBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengunggah...';

                // Kirim file ke server menggunakan FormData dan fetch API
                const formData = new FormData(uploadLampiranForm);

                fetch(uploadLampiranForm.action, {
                    method: 'POST',
                    body: formData,
                    // Perbaiki cara mengirim CSRF token
                    // Tidak perlu menambahkan CSRF token di headers jika menggunakan FormData
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan section sukses jika upload berhasil
                        uploadLampiranSection.classList.add('d-none');
                        uploadSuccessSection.classList.remove('d-none');

                        // Tambahkan hidden field untuk menyimpan path file ke form ajukan
                        // Cari form dengan cara yang lebih reliable
                        const ajukanForm = document.querySelector('form[action*="ajukan"]');
                        if (ajukanForm) {
                            // Hapus hidden field yang mungkin sudah ada sebelumnya
                            const existingField = ajukanForm.querySelector('input[name="file_path"]');
                            if (existingField) {
                                existingField.remove();
                            }

                            // Buat dan tambahkan hidden field baru
                            const hiddenField = document.createElement('input');
                            hiddenField.type = 'hidden';
                            hiddenField.name = 'file_path';
                            hiddenField.value = data.path;
                            ajukanForm.appendChild(hiddenField);
                        }
                    } else {
                        alert('Error: ' + data.message);
                        uploadLampiranBtn.disabled = false;
                        uploadLampiranBtn.innerHTML = '<i class="fas fa-upload me-1"></i> Unggah Lampiran';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengunggah berkas.');
                    uploadLampiranBtn.disabled = false;
                    uploadLampiranBtn.innerHTML = '<i class="fas fa-upload me-1"></i> Unggah Lampiran';
                });
            });

            if (changeFileBtn) {
                changeFileBtn.addEventListener('click', function() {
                    uploadSuccessSection.classList.add('d-none');
                    uploadLampiranSection.classList.remove('d-none');
                    tempFileInput.value = '';
                });
            }
        }

        // Cek status validasi surat untuk disable tombol hapus
        const suratStatus = "{{ $surat->status ?? '' }}";
        if (suratStatus === 'valid') {
            // Sembunyikan semua tombol hapus jika surat valid
            const deleteButtons = document.querySelectorAll('button[data-bs-target="#hapusLampiranModal"]');
            deleteButtons.forEach(button => {
                button.style.display = 'none';
            });

            // Tambahkan info ke modal jika diakses melalui kode
            const modalBody = document.querySelector('#hapusLampiranModal .modal-body');
            if (modalBody) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i> <strong>Perhatian:</strong> Lampiran yang sudah divalidasi tidak dapat dihapus.';
                modalBody.prepend(alertDiv);
            }
        }

        function validateFileSize(fileInput) {
            const fileName = fileInput.files[0]?.name;
            if (fileName) {
                const fileSize = (fileInput.files[0].size / 1024 / 1024).toFixed(2);
                if (fileSize > 5) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    fileInput.value = '';
                } else {
                    console.log(`File dipilih: ${fileName} (${fileSize}MB)`);
                }
            }
        }
    });
</script>
@endpush
