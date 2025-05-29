@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Template Surat Section -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Template Surat Pernyataan</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadTemplateModal">
                        <i class="fas fa-upload me-1"></i> Upload Template
                    </button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Template</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Upload</th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $index => $template)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $template->nama_template }}</h6>
                                                @if($template->deskripsi)
                                                <p class="text-xs text-secondary mb-0">{{ $template->deskripsi }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <a href="{{ Storage::url('templates/' . $template->file_template) }}" target="_blank" class="text-sm font-weight-bold mb-0">
                                                    <i class="fas fa-file-alt text-info"></i> Lihat File
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($template->status == 'aktif')
                                            <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $template->created_at->format('d/m/Y') }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $template->created_at->format('H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('admin.template.toggle-status', $template->id_template) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $template->status == 'aktif' ? 'btn-warning' : 'btn-success' }} me-1"
                                                    onclick="return confirm('Ubah status template ini?')">
                                                <i class="fas {{ $template->status == 'aktif' ? 'fa-pause' : 'fa-play' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.template.delete', $template->id_template) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus template ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-file-alt fa-3x text-secondary mb-3"></i>
                                            <h6 class="text-secondary">Belum ada template surat yang diunggah</h6>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Surat Pernyataan Mahasiswa Section -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $page->title }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIM</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Mahasiswa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Upload</th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suratPernyataan as $index => $surat)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $surat->nim }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $surat->mahasiswa->nama ?? 'N/A' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $surat->mahasiswa->program_studi ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <a href="{{ Storage::url('surat/' . $surat->file_surat_pernyataan) }}" target="_blank" class="text-sm font-weight-bold mb-0">
                                                    <i class="fas fa-file-pdf text-danger"></i> Lihat PDF
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($surat->status == 'pending')
                                            <span class="badge badge-sm bg-gradient-warning">Menunggu</span>
                                        @elseif($surat->status == 'valid')
                                            <span class="badge badge-sm bg-gradient-success">Valid</span>
                                        @elseif($surat->status == 'rejected')
                                            <span class="badge badge-sm bg-gradient-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $surat->created_at->format('d/m/Y') }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $surat->created_at->format('H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.surat-pernyataan.show', $surat->id_surat_pernyataan) }}" class="btn btn-sm btn-outline-info me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($surat->status == 'pending')
                                        <form action="{{ route('admin.surat-pernyataan.validate', $surat->id_surat_pernyataan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success me-1" onclick="return confirm('Validasi dokumen ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.surat-pernyataan.reject', $surat->id_surat_pernyataan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak dokumen ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-file-alt fa-3x text-secondary mb-3"></i>
                                            <h6 class="text-secondary">Belum ada surat pernyataan yang diunggah</h6>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Template -->
<div class="modal fade" id="uploadTemplateModal" tabindex="-1" aria-labelledby="uploadTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadTemplateModalLabel">Upload Template Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.template.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_template" class="form-label">Nama Template <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_template" name="nama_template" required>
                    </div>
                    <div class="mb-3">
                        <label for="file_template" class="form-label">File Template <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file_template" name="file_template" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Format yang didukung: PDF, DOC, DOCX (Maksimal 5MB)</div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi template (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
