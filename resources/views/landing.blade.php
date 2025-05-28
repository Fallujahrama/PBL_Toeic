<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TOEIC Center - Politeknik Negeri Malang</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">TOEIC Center Polinema</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation"
                    aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-white">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="min-vh-100 d-flex align-items-center bg-gradient-primary">
        <div class="container position-relative z-index-2">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center text-white">
                    <h1 class="display-3 fw-bold mb-3">Selamat Datang di TOEIC Center</h1>
                    <p class="lead mb-5">Test of English for International Communication (TOEIC) - Politeknik Negeri Malang</p>
                    <a href="{{ route('login') }}" class="btn btn-lg btn-white">Mulai Sekarang</a>
                </div>
            </div>
        </div>
        <!-- Waves -->
        <div class="position-absolute bottom-0 w-100">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 40" preserveAspectRatio="none">
                <defs>
                    <path id="wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="moving-waves">
                    <use href="#wave" x="48" y="-1" fill="rgba(255,255,255,0.40)" />
                    <use href="#wave" x="48" y="3" fill="rgba(255,255,255,0.35)" />
                    <use href="#wave" x="48" y="5" fill="rgba(255,255,255,0.25)" />
                    <use href="#wave" x="48" y="8" fill="rgba(255,255,255,0.20)" />
                    <use href="#wave" x="48" y="13" fill="rgba(255,255,255,0.15)" />
                    <use href="#wave" x="48" y="16" fill="#ffffff" />
                </g>
            </svg>
        </div>
    </header>

    <!-- Features -->
    <section class="py-7">
        <div class="container">
            <div class="row justify-content-center text-center mb-6">
                <div class="col-lg-8">
                    <h2 class="mb-4">Mengapa TOEIC?</h2>
                    <p class="lead">TOEIC adalah standar internasional untuk mengukur kemampuan bahasa Inggris dalam konteks profesional dan akademik</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="icon-box mb-4">
                                <i class="fas fa-globe fa-3x text-primary"></i>
                            </div>
                            <h3 class="h5 mb-3">Standar Internasional</h3>
                            <p class="text-muted">Diakui secara global oleh lebih dari 14.000+ organisasi di 160+ negara.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="icon-box mb-4">
                                <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                            </div>
                            <h3 class="h5 mb-3">Fokus Karir</h3>
                            <p class="text-muted">Dirancang khusus untuk menguji kemampuan bahasa Inggris dalam konteks pekerjaan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="icon-box mb-4">
                                <i class="fas fa-chart-line fa-3x text-primary"></i>
                            </div>
                            <h3 class="h5 mb-3">Pengembangan Diri</h3>
                            <p class="text-muted">Tingkatkan prospek karir dan akademik Anda dengan sertifikasi TOEIC.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="py-7 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="display-4 fw-bold text-primary mb-2">7M+</div>
                    <h5 class="text-muted">Peserta Tes per Tahun</h5>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="display-4 fw-bold text-primary mb-2">160+</div>
                    <h5 class="text-muted">Negara Pengguna</h5>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="display-4 fw-bold text-primary mb-2">14K+</div>
                    <h5 class="text-muted">Organisasi Partner</h5>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="display-4 fw-bold text-primary mb-2">35+</div>
                    <h5 class="text-muted">Tahun Pengalaman</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- Test Sections -->
    <section class="py-7">
        <div class="container">
            <div class="row justify-content-center text-center mb-6">
                <div class="col-lg-8">
                    <h2 class="mb-4">Komponen Tes TOEIC</h2>
                    <p class="lead">TOEIC terdiri dari dua bagian utama yang menguji kemampuan mendengar dan membaca</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="h4 mb-4">
                                <i class="fas fa-headphones me-2 text-primary"></i>
                                Listening Section
                            </h3>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>100 pertanyaan</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>45 menit durasi</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>Skor 5-495 poin</li>
                                <li><i class="fas fa-check text-success me-2"></i>Menguji pemahaman lisan</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="h4 mb-4">
                                <i class="fas fa-book-reader me-2 text-primary"></i>
                                Reading Section
                            </h3>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>100 pertanyaan</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>75 menit durasi</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>Skor 5-495 poin</li>
                                <li><i class="fas fa-check text-success me-2"></i>Menguji pemahaman bacaan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-7 bg-gradient-primary text-white">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="mb-4">Siap Untuk Memulai?</h2>
                    <p class="lead mb-5">Tingkatkan kemampuan bahasa Inggris Anda dan raih sertifikasi TOEIC sekarang!</p>
                    <a href="{{ route('login') }}" class="btn btn-lg btn-white">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="mb-0 text-white-50">
                        © <script>document.write(new Date().getFullYear())</script> TOEIC Center - Politeknik Negeri Malang
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
