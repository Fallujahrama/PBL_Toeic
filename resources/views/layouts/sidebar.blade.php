<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('welcome') }}">
            <img src="{{ asset('img/Tregon.jpeg') }}" class="navbar-brand-img h-100" alt="Tregon Logo">
            <span class="ms-1 font-weight-bold">TOEIC Center</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @php
                $userRole = Auth::user()->level->level_kode ?? null;
                $isAdmin = in_array($userRole, ['AdmUpa', 'AdmITC']);
                $isAdminUpa = $userRole === 'AdmUpa';
                $isAdminITC = $userRole === 'AdmITC';
                $isStudent = $userRole === 'Mhs';
                $currentUrl = url()->current();
            @endphp

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'dashboard') !== false ? 'active' : '' }}" href="{{ $isAdmin ? route('admin.dashboard') : route('mahasiswa.dashboard') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Data Mahasiswa - Only for AdminITC -->
            @if($isAdminITC)
            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'admin/mahasiswa') !== false ? 'active' : '' }}" href="{{ route('admin.mahasiswa.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Data Mahasiswa</span>
                </a>
            </li>
            @endif

            <!-- Admin Menu Items - Only for AdmUpa -->
            @if($isAdminUpa)
            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'jadwal') !== false ? 'active' : '' }}" href="{{ route('jadwal.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-alt text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Jadwal</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'hasil_ujian') !== false ? 'active' : '' }}" href="{{ route('hasil_ujian.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-chart-bar text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Hasil Ujian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'surat-pernyataan') !== false ? 'active' : '' }}" href="{{ route('admin.surat-pernyataan.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-signature text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Surat Pernyataan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'verifikasi') !== false ? 'active' : '' }}" href="{{ route('verifikasi.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Verifikasi</span>
                </a>
            </li>
            @endif

            <!-- Student Menu Items - Only for Students -->
            @if($isStudent)
            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'pendaftaran') !== false ? 'active' : '' }}" href="{{ route('pendaftaran.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pendaftaran</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'mahasiswa/jadwal') !== false ? 'active' : '' }}" href="{{ route('mahasiswa.jadwal') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-alt text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Jadwal</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'hasil-ujian') !== false ? 'active' : '' }}" href="{{ route('mahasiswa.hasil_ujian') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-chart-bar text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Hasil Ujian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'surat-pernyataan') !== false ? 'active' : '' }}" href="{{ route('mahasiswa.surat-pernyataan.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-signature text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Surat Pernyataan</span>
                </a>
            </li>
            @endif

            <!-- Profile - For all users -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ strpos($currentUrl, 'profile') !== false ? 'active' : '' }}" href="{{ route('profile') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-circle text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>
