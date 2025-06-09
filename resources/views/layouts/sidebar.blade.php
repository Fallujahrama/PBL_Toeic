<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 sidebar-outlined" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('/') }}">
      <div class="d-flex flex-column align-items-center justify-content-center py-3">

        <div class="text-center">
        <img src="{{ asset('img/Tregon.png') }}" alt="TOEIC Center Logo" class="sidebar-logo mb-2">
          <span class="font-weight-bold text-sm">TOEIC Center</span>
        </div>
      </div>
    </a>
  </div>

  <hr class="horizontal dark mt-0">

  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      @php
        $userRole = Auth::user()->level->level_kode ?? null;
        $isAdmin = in_array($userRole, ['AdmUpa', 'AdmITC', 'SprAdmin']);
        $isAdminUpa = $userRole === 'AdmUpa';
        $isAdminITC = $userRole === 'AdmITC';
        $isStudent = $userRole === 'Mhs';
        $isAlumni = $userRole === 'Alum';
        $isDosen = $userRole === 'Dsn';
        $isCivitas = $userRole === 'Cvts';
        $isNormalUser = in_array($userRole, ['Mhs', 'Alum', 'Dsn', 'Cvts']);
        $isSuperAdmin = $userRole === 'SprAdmin';
        $currentUrl = url()->current();
      @endphp

      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'dashboard') !== false ? 'active' : '' }}"
           href="{{ ($isAdminUpa || $isSuperAdmin) ? route('admin.dashboard') : ($isAdminITC ? route('welcome') : route('mahasiswa.dashboard')) }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <!-- Data Mahasiswa - Only for AdminITC -->
      @if($isAdminITC)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'admin/mahasiswa') !== false ? 'active' : '' }}"
           href="{{ route('admin.mahasiswa.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-users text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Data Mahasiswa</span>
        </a>
      </li>
      @endif

      <!-- User Management - Only for SuperAdmin -->
      @if($isSuperAdmin)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'admin/users') !== false ? 'active' : '' }}"
           href="{{ route('admin.users.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-cog text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Manajemen User</span>
        </a>
      </li>
      @endif

      <!-- Pendaftaran - For all normal users -->
      @if($isNormalUser)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'pendaftaran') !== false ? 'active' : '' }}"
           href="{{ route('pendaftaran.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-clipboard-list text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Pendaftaran</span>
        </a>
      </li>
      @endif

      <!-- Jadwal -->
      @if($isAdminUpa || $isSuperAdmin || $isNormalUser)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'jadwal') !== false ? 'active' : '' }}"
           href="{{ ($isAdminUpa || $isSuperAdmin) ? route('jadwal.index') : route('mahasiswa.jadwal') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-calendar-alt text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Jadwal</span>
        </a>
      </li>
      @endif

      <!-- Hasil Ujian -->
      @if($isAdminUpa || $isSuperAdmin || $isNormalUser)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'hasil-ujian') !== false || strpos($currentUrl, 'hasil_ujian') !== false ? 'active' : '' }}"
           href="{{ ($isAdminUpa || $isSuperAdmin) ? route('hasil_ujian.index') : route('mahasiswa.hasil_ujian') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-bar text-info text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Hasil Ujian</span>
        </a>
      </li>
      @endif

      <!-- Surat Pernyataan - Only for AdmUpa, SuperAdmin and Students (NOT for Alumni, Dosen, Civitas) -->
      @if($isAdminUpa || $isSuperAdmin || $isStudent)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'surat-pernyataan') !== false ? 'active' : '' }}"
           href="{{ ($isAdminUpa || $isSuperAdmin) ? route('admin.surat-pernyataan.index') : route('mahasiswa.surat-pernyataan.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-file-signature text-danger text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Surat Pernyataan</span>
        </a>
      </li>
      @endif

      <!-- Verifikasi - Only for AdmUpa and SuperAdmin -->
      @if($isAdminUpa || $isSuperAdmin)
      <li class="nav-item">
        <a class="nav-link {{ request()->is('*verifikasi*') ? 'active' : '' }}" href="{{ route('verifikasi.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-check-circle text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Verifikasi</span>

          @php
            try {
              $pendingCount = App\Models\PendaftaranModel::where('status_verifikasi', 'pending')
                ->orWhereNull('status_verifikasi')
                ->count();
            } catch (Exception $e) {
              $pendingCount = 0;
            }
          @endphp

          @if($pendingCount > 0)
          <span class="verification-badge">{{ $pendingCount }}</span>
          @endif
        </a>
      </li>
      @endif

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'profile') !== false ? 'active' : '' }}" href="{{ route('profile') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-circle text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Profil</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="sidenav-footer mx-3 mt-3">
    <div class="card card-plain shadow-none" id="sidenavCard">
      <div class="card-body text-center p-3 w-100 pt-0">
        <div class="docs-info">
          <h6 class="mb-0">TOEIC Center</h6>
          <p class="text-xs font-weight-bold mb-0">Pusat Pendaftaran TOEIC</p>
        </div>
      </div>
    </div>

    <a class="btn btn-dark btn-sm w-100" href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form-footer').submit();">
      <i class="fas fa-sign-out-alt me-2"></i> Logout
    </a>
    <form id="logout-form-footer" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
</aside>

<style>
.sidebar-outlined {
  border: 1px solid #e9ecef !important;
  box-shadow: 0 4px 25px 0 rgba(0, 0, 0, 0.1), 0 8px 50px 0 rgba(0, 0, 0, 0.07) !important;
  background: #ffffff !important;
}

.verification-badge {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    color: white;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: auto;
    font-weight: bold;
    min-width: 18px;
    text-align: center;
    display: inline-block;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
}

.sidebar-logo {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 50%;
  border: 3px solid #fff;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Additional outline styling for better separation */
.sidenav-header {
  border-bottom: 1px solid #f0f2f5;
}

.sidenav-footer {
  border-top: 1px solid #f0f2f5;
  padding-top: 1rem !important;
}
</style>
