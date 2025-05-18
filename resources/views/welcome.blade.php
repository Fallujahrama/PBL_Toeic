@extends('layouts.template')

@section('title', 'Welcome to TOEIC Center')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                @foreach($breadcrumb->list as $key => $value)
                    @if ($key < count($breadcrumb->list) - 1)
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-dark" href="#">{{ $value }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $value }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
        <h6 class="font-weight-bolder mb-0">{{ $breadcrumb->title }}</h6>
    </div>

    <!-- Welcome Header -->
    <div class="welcome-header card-gradient-primary text-white" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="text-white mb-3">Selamat Datang di Sistem Pendaftaran TOEIC</h3>
                <p class="mb-4 opacity-8">Tingkatkan kemampuan bahasa Inggris Anda dan dapatkan sertifikasi internasional yang diakui di seluruh dunia. Silakan cek jadwal terbaru, persyaratan, dan segera daftarkan dirimu untuk mengikuti tes TOEIC!</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-light btn-sm mb-0 me-1 pulse">
                        <i class="fas fa-user-plus me-1"></i> Daftar Sekarang
                    </a>
                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline-light btn-sm mb-0">
                        <i class="fas fa-calendar-alt me-1"></i> Lihat Jadwal
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="fas fa-language fa-6x opacity-8"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="counter-value" data-count="1500">0</div>
                        <div class="counter-title">Peserta Terdaftar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="counter-value" data-count="24">0</div>
                        <div class="counter-title">Jadwal Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="counter-value" data-count="990">0</div>
                        <div class="counter-title">Sertifikat Terbit</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="400">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="counter-card">
                        <div class="counter-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="counter-value" data-count="45">0</div>
                        <div class="counter-title">Perusahaan Partner</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Process -->
    <div class="row mt-4">
        <div class="col-12 mb-4" data-aos="fade-up">
            <div class="card animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h6 class="mb-0">Proses Pendaftaran TOEIC</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">1</span>
                                </div>
                                <h6>Pilih Jenis Pendaftaran</h6>
                                <p class="text-sm mb-0">Pilih antara pendaftaran pertama atau pendaftaran kedua sesuai status Anda</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">2</span>
                                </div>
                                <h6>Isi Formulir</h6>
                                <p class="text-sm mb-0">Lengkapi formulir dengan data diri dan upload dokumen yang diperlukan</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">3</span>
                                </div>
                                <h6>Pembayaran</h6>
                                <p class="text-sm mb-0">Lakukan pembayaran biaya pendaftaran sebesar Rp150.000 via transfer bank</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="text-center p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <div class="icon icon-shape icon-lg bg-gradient-primary text-white rounded-circle shadow mb-3 mx-auto">
                                    <span class="fw-bold">4</span>
                                </div>
                                <h6>Konfirmasi</h6>
                                <p class="text-sm mb-0">Dapatkan konfirmasi pendaftaran dan jadwal tes melalui email dan WhatsApp</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Mulai Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mt-2">
        <!-- Card Info Jadwal -->
        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card info-card shadow animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-2">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h6 class="mb-0">Jadwal Tes TOEIC Terdekat</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1 text-dark">Gelombang 1</h6>
                                <p class="text-sm mb-0">20 Mei 2025 - Laboratorium Bahasa, Gedung E</p>
                                <span class="badge bg-gradient-primary mt-2">Pendaftaran Dibuka</span>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1 text-dark">Gelombang 2</h6>
                                <p class="text-sm mb-0">10 Juni 2025 - Laboratorium Bahasa, Gedung E</p>
                                <span class="badge bg-gradient-warning mt-2">Segera Dibuka</span>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1 text-dark">Gelombang 3</h6>
                                <p class="text-sm mb-0">15 Juli 2025 - Laboratorium Bahasa, Gedung E</p>
                                <span class="badge bg-gradient-secondary mt-2">Coming Soon</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Jadwal</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Info Persyaratan -->
        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card info-card shadow animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-success text-white rounded-circle shadow me-2">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h6 class="mb-0">Persyaratan Pendaftaran</h6>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Mahasiswa aktif dengan KTM yang masih berlaku</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Upload scan KTP (Kartu Tanda Penduduk)</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Upload scan KTM (Kartu Tanda Mahasiswa)</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Upload pas foto terbaru (background biru/merah)</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Biaya pendaftaran: Rp150.000 (transfer bank)</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0 ps-0">
                            <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Mengisi formulir pendaftaran online</span>
                        </li>
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ route('pendaftaran.index') }}" class="btn btn-sm btn-outline-success">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About TOEIC -->
    <div class="row" data-aos="fade-up" data-aos-delay="300">
        <div class="col-12 mb-4">
            <div class="card animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-info text-white rounded-circle shadow me-2">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h6 class="mb-0">Tentang TOEIC</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p>Test of English for International Communication (TOEIC) adalah standar evaluasi kemampuan bahasa Inggris untuk lingkungan kerja internasional. Tes ini mengukur kemampuan seseorang dalam berkomunikasi menggunakan bahasa Inggris di lingkungan bisnis dan pekerjaan.</p>
                            
                            <h6 class="mt-4 mb-3">Manfaat Sertifikasi TOEIC:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="ps-3">
                                        <li class="mb-2">Diakui secara internasional oleh perusahaan global</li>
                                        <li class="mb-2">Meningkatkan daya saing dalam dunia kerja</li>
                                        <li class="mb-2">Menjadi nilai tambah dalam CV dan lamaran kerja</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="ps-3">
                                        <li class="mb-2">Memenuhi persyaratan kelulusan di banyak universitas</li>
                                        <li class="mb-2">Membantu dalam program pertukaran pelajar</li>
                                        <li class="mb-2">Berlaku selama 2 tahun sejak tanggal tes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 h-100" style="background-color: var(--dark-hover); border: 1px solid var(--dark-border);">
                                <h6 class="mb-3">Komponen Tes TOEIC:</h6>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                        <i class="fas fa-headphones"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-sm">Listening Comprehension</h6>
                                        <p class="text-xs mb-0">100 soal (45 menit)</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-xs bg-gradient-primary text-white rounded-circle shadow me-3">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-sm">Reading Comprehension</h6>
                                        <p class="text-xs mb-0">100 soal (75 menit)</p>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-top border-secondary">
                                    <p class="text-xs mb-0">Total skor: 10-990 poin</p>
                                    <p class="text-xs mb-0">Durasi tes: 120 menit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row" data-aos="fade-up" data-aos-delay="400">
        <div class="col-12 mb-4">
            <div class="card animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-warning text-white rounded-circle shadow me-2">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h6 class="mb-0">Frequently Asked Questions</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="faq-item p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <h6 class="mb-2"><i class="fas fa-question-circle me-2 text-primary"></i>Bagaimana cara mendaftar tes TOEIC?</h6>
                                <p class="text-sm mb-0">Anda dapat mendaftar melalui website ini dengan memilih menu "Pendaftaran", kemudian pilih jenis pendaftaran sesuai status Anda (baru/lama), isi formulir, dan upload dokumen yang diperlukan.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="faq-item p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <h6 class="mb-2"><i class="fas fa-question-circle me-2 text-primary"></i>Berapa biaya pendaftaran TOEIC?</h6>
                                <p class="text-sm mb-0">Biaya pendaftaran TOEIC adalah Rp150.000 yang dapat dibayarkan melalui transfer bank ke rekening yang tertera pada halaman pendaftaran.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="faq-item p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <h6 class="mb-2"><i class="fas fa-question-circle me-2 text-primary"></i>Berapa lama sertifikat TOEIC berlaku?</h6>
                                <p class="text-sm mb-0">Sertifikat TOEIC berlaku selama 2 tahun sejak tanggal tes dilaksanakan. Setelah itu, Anda disarankan untuk mengambil tes kembali untuk memperbarui skor Anda.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="faq-item p-3 rounded-3" style="background-color: var(--dark-hover);">
                                <h6 class="mb-2"><i class="fas fa-question-circle me-2 text-primary"></i>Kapan saya bisa mendapatkan hasil tes?</h6>
                                <p class="text-sm mb-0">Hasil tes TOEIC biasanya dikeluarkan dalam waktu 7-14 hari kerja setelah pelaksanaan tes. Anda akan mendapatkan notifikasi melalui email dan WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcement Card -->
    <div class="row" data-aos="fade-up" data-aos-delay="500">
        <div class="col-12 mb-4">
            <div class="card animate-card">
                <div class="card-body p-3">
                    <div class="d-flex">
                        <div class="icon icon-shape icon-lg bg-gradient-info text-white rounded-circle shadow me-3">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Pengumuman Penting</h5>
                            <p class="mb-0">Bagi seluruh peserta TOEIC, harap membawa kartu identitas dan bukti pembayaran saat hari pelaksanaan tes. Peserta diharapkan hadir 30 menit sebelum tes dimulai untuk proses registrasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="row" data-aos="fade-up" data-aos-delay="600">
        <div class="col-12 mb-4">
            <div class="card animate-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-success text-white rounded-circle shadow me-2">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h6 class="mb-0">Kontak Informasi</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-sm">Email</h6>
                                    <p class="text-sm mb-0">toeic.center@example.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-3">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-sm">Telepon</h6>
                                    <p class="text-sm mb-0">(021) 1234-5678</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow me-3">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-sm">WhatsApp</h6>
                                    <p class="text-sm mb-0">+62 812-3456-7890</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Add pulse effect to the "Daftar Sekarang" button
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const registerBtn = document.querySelector('.welcome-header .btn-light');
            if (registerBtn) {
                registerBtn.classList.add('pulse');
            }
        }, 2000);
    });
</script>
@endpush
