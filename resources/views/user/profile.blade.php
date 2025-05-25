@extends('layouts.template')

@section('title', 'User Profile - TOEIC Center')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Profile</li>
        </ol>
    </nav>
    <h6 class="font-weight-bolder mb-0">User Profile</h6>
</div>

<div class="row">
    <div class="col-12">
        <div class="card animate-card" data-aos="fade-up">
            <div class="card-header d-flex align-items-center">
                <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                    <i class="fas fa-user"></i>
                </div>
                <h5 class="mb-0">Profile Pengguna</h5>
            </div>
            {{-- Tombol Edit Profil
            @if(auth()->user()->hasRole('Mhs'))
                <a href="{{ route('mahasiswa.profile.edit') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit me-1"></i>Edit Profil
                </a>
            @else
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit me-1"></i>Edit Profil
                </a>
            @endif --}}

            <div class="card-body">
                <div class="row">
                    {{-- Foto Profil --}}
                    <div class="col-md-4 text-center" data-aos="fade-right" data-aos-delay="100">
                        <div class="position-relative">
                            <div class="profile-image-container mb-4">
                                <img src="{{ $user->foto_profil ? asset('storage/'.$user->foto_profil) : asset('img/default-profile.png') }}"
                                    class="profile-image" alt="User Image" id="profile-preview">
                                <div class="profile-image-overlay">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>

                            {{-- Form Upload Foto --}}
                            <form action="{{ url('/user/editPhoto') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="file" class="form-control d-none" id="foto_profil" name="foto_profil" accept="image/*">
                                        <label for="foto_profil" class="btn btn-outline-primary w-100 mb-0">
                                            <i class="fas fa-upload me-2"></i>Pilih Foto
                                        </label>
                                    </div>
                                    @error('foto_profil')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    <i class="fas fa-save me-2"></i>Update Foto
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Informasi User --}}
                    <div class="col-md-8" data-aos="fade-left" data-aos-delay="200">
                        <div class="info-card">
                            <div class="card-header">
                                <h6>Data User</h6>
                            </div>
                            <div class="card-body">
                                <div class="profile-info-item mb-3">
                                    <div class="profile-info-label">
                                        <i class="fas fa-user-circle me-2"></i>Username
                                    </div>
                                    <div class="profile-info-value">
                                        {{ $user->username }}
                                    </div>
                                </div>

                                @if(auth()->user()->hasRole('Mhs'))
                                    {{-- Mahasiswa --}}
                                    <div class="profile-info-item mb-3">
                                        <div class="profile-info-label">
                                            <i class="fas fa-id-card me-2"></i>Nama
                                        </div>
                                        <div class="profile-info-value">
                                            {{ $user->mahasiswa->nama ?? 'Nama Belum Diisi' }}
                                        </div>
                                    </div>
                                    <div class="profile-info-item mb-3">
                                        <div class="profile-info-label">
                                            <i class="fas fa-phone me-2"></i>No. WhatsApp
                                        </div>
                                        <div class="profile-info-value">
                                            {{ $user->mahasiswa->no_whatsapp ?? '-' }}
                                        </div>
                                    </div>

                                    <a href="{{ route('mahasiswa.profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit Profil
                                    </a>
                                @else
                                    {{-- Admin --}}
                                    <div class="profile-info-item mb-3">
                                        <div class="profile-info-label">
                                            <i class="fas fa-id-card me-2"></i>Nama
                                        </div>
                                        <div class="profile-info-value">
                                            {{ $user->admin->nama ?? 'Nama Belum Diisi' }}
                                        </div>
                                    </div>
                                    <div class="profile-info-item mb-3">
                                        <div class="profile-info-label">
                                            <i class="fas fa-phone me-2"></i>No. WhatsApp
                                        </div>
                                        <div class="profile-info-value">
                                            {{ $user->admin->no_hp ?? '-' }}
                                        </div>
                                    </div>

                                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit Profil
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div> {{-- end col --}}
                </div> {{-- end row --}}
            </div> {{-- end card-body --}}
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Klik pada ikon kamera untuk membuka file picker
        $('.profile-image-overlay').on('click', function() {
            $('#foto_profil').click();
        });

        // Preview gambar setelah memilih file
        $('#foto_profil').on('change', function() {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);

                // Tampilkan nama file
                let fileName = $(this).val().split('\\').pop();
                $(this).next('label').html('<i class="fas fa-check me-2"></i>' + fileName);
            }
        });
    });
</script>
@endpush
