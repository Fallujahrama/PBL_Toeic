@extends('layouts.template')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/') }}">Home</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pendaftaran</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">{{ $page->title ?? 'Pendaftaran Mahasiswa' }}</h6>
</div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm animate-card" data-aos="fade-up">
                <div class="card-header text-center">
                    <h2 class="fw-bold">TOEIC Test Registration</h2>
                    <p>Please select the registration type</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Mahasiswa Baru -->
                        <div class="col-md-6 mb-3" data-aos="fade-right" data-aos-delay="100">
                            <div class="card p-4 text-center h-100 shadow-sm animate-card"
                                 style="border: 1px solid var(--dark-border); background-color: var(--dark-card); cursor: pointer; {{ $hasRegistered ? 'pointer-events: none; opacity: 0.5;' : '' }}"
                                 onclick="{{ $hasRegistered ? '' : "window.location='" . route('pendaftaran.baru') . "'" }}">
                                <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                                <h4>First Registration</h4>
                                <p>First Registration Form</p>
                                @if ($hasRegistered)
                                    <small class="text-danger">You have already registered.</small>
                                @endif
                            </div>
                        </div>
                        <!-- Mahasiswa Lama -->
                        <div class="col-md-6 mb-3" data-aos="fade-left" data-aos-delay="200">
                            <div class="card p-4 text-center h-100 shadow-sm animate-card" style="border: 1px solid var(--dark-border); background-color: var(--dark-card); cursor: pointer;" onclick="window.location='{{ route('pendaftaran.lama') }}'">
                                <i class="fas fa-user-edit fa-3x mb-3 text-warning"></i>
                                <h4>Second Registration</h4>
                                <p>Second Registration Form</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- Tabel History Pendaftaran -->
    @if($registrations->count() > 0)
    <div class="row justify-content-center mt-4">
        <div class="col-md-12" data-aos="fade-up" data-aos-delay="500">
            <div class="card shadow-sm animate-card" style="background-color: var(--dark-card); border: 1px solid var(--dark-border);">
                <div class="card-header">
                    <h5><i class="fas fa-history me-2 text-info"></i>Registration History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="registrationTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Registration Date</th>
                                    <th>Registration Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $index => $registration)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $registration->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        @if($index == $registrations->count() - 1)
                                            <span class="badge bg-primary">First Registration</span>
                                        @else
                                            <span class="badge bg-warning">Second Registration</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($registration->keterangan === 'EDITED')
                                            <span class="badge bg-danger">Edited (Locked)</span>
                                        @elseif($registration->created_at != $registration->updated_at)
                                            <span class="badge bg-info">Updated</span>
                                        @else
                                            <span class="badge bg-success">Submitted</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($registration->keterangan === 'EDITED')
                                            <button class="btn btn-sm btn-secondary" disabled title="Sudah diedit, tidak dapat diubah lagi">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @else
                                            <a href="{{ route('mahasiswa.data.edit', $registration->nim) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Penjelasan di bawah card -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-12" data-aos="fade-up" data-aos-delay="300">
            <div class="card p-4 shadow-sm animate-card" style="background-color: var(--dark-card); border: 1px solid var(--dark-border);">
                <h5><i class="fas fa-info-circle me-2 text-primary"></i>First Registration</h5>
                <p class="text-muted">This registration form for students who are taking the TOEIC exam for the first time.</p>
            </div>
        </div>
        <div class="col-md-12 mt-3" data-aos="fade-up" data-aos-delay="400">
            <div class="card p-4 shadow-sm animate-card" style="background-color: var(--dark-card); border: 1px solid var(--dark-border);">
                <h5><i class="fas fa-info-circle me-2 text-warning"></i>Second Registration</h5>
                <p class="text-muted">This registration form for students who have previously taken the TOEIC exam.</p>
            </div>
        </div>
    </div>

  
</div>

<!-- Modal for Registration Details -->
<div class="modal fade" id="registrationDetailModal" tabindex="-1" aria-labelledby="registrationDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationDetailModalLabel">Registration Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="registrationDetailContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
.table th {
    background-color: var(--dark-header);
    color: white;
    border: none;
}

.table td {
    border-color: var(--dark-border);
}

.table-hover tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.05);
}

.animate-card {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@push('js')
<script>
function viewRegistration(id) {
    // Show loading state
    const content = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading registration details...</p>
        </div>
    `;
    document.getElementById('registrationDetailContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('registrationDetailModal')).show();

    fetch(`/pendaftaran/${id}/show`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                const registration = data.data;
                const mahasiswa = registration.mahasiswa;
                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Student Information</h6>
                            <p><strong>NIM:</strong> ${registration.nim}</p>
                            ${mahasiswa ? `
                                <p><strong>Name:</strong> ${mahasiswa.nama}</p>
                                <p><strong>Study Program:</strong> ${mahasiswa.program_studi}</p>
                                <p><strong>Department:</strong> ${mahasiswa.jurusan}</p>
                                <p><strong>Campus:</strong> ${mahasiswa.kampus}</p>
                            ` : ''}
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info mb-3"><i class="fas fa-calendar me-2"></i>Registration Details</h6>
                            <p><strong>Registration Date:</strong> ${new Date(registration.created_at).toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}</p>
                            <p><strong>Last Updated:</strong> ${new Date(registration.updated_at).toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-success mb-3"><i class="fas fa-file-alt me-2"></i>Uploaded Files</h6>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="text-center p-2 border rounded">
                                        <i class="fas fa-id-card fa-2x ${registration.file_ktp ? 'text-success' : 'text-muted'} mb-2"></i>
                                        <p class="mb-1"><strong>KTP</strong></p>
                                        <span class="badge ${registration.file_ktp ? 'bg-success' : 'bg-secondary'}">
                                            ${registration.file_ktp ? 'Uploaded' : 'Not uploaded'}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="text-center p-2 border rounded">
                                        <i class="fas fa-id-badge fa-2x ${registration.file_ktm ? 'text-success' : 'text-muted'} mb-2"></i>
                                        <p class="mb-1"><strong>KTM</strong></p>
                                        <span class="badge ${registration.file_ktm ? 'bg-success' : 'bg-secondary'}">
                                            ${registration.file_ktm ? 'Uploaded' : 'Not uploaded'}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="text-center p-2 border rounded">
                                        <i class="fas fa-user-circle fa-2x ${registration.file_foto ? 'text-success' : 'text-muted'} mb-2"></i>
                                        <p class="mb-1"><strong>Photo</strong></p>
                                        <span class="badge ${registration.file_foto ? 'bg-success' : 'bg-secondary'}">
                                            ${registration.file_foto ? 'Uploaded' : 'Not uploaded'}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="text-center p-2 border rounded">
                                        <i class="fas fa-receipt fa-2x ${registration.file_bukti_pembayaran ? 'text-success' : 'text-muted'} mb-2"></i>
                                        <p class="mb-1"><strong>Payment Proof</strong></p>
                                        <span class="badge ${registration.file_bukti_pembayaran ? 'bg-success' : 'bg-secondary'}">
                                            ${registration.file_bukti_pembayaran ? 'Uploaded' : 'Not uploaded'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('registrationDetailContent').innerHTML = content;
            } else {
                throw new Error(data.message || 'Unknown error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorContent = `
                <div class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h5>Error Loading Details</h5>
                    <p>${error.message || 'Failed to load registration details. Please try again.'}</p>
                </div>
            `;
            document.getElementById('registrationDetailContent').innerHTML = errorContent;
        });
}

// Initialize DataTable if available
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#registrationTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[1, 'desc']], // Sort by date descending
            columnDefs: [
                { orderable: false, targets: [4] } // Disable sorting for Actions column
            ]
        });
    }
});
</script>
@endpush
@endsection
