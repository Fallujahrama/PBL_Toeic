<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" id="iconSidenav"></i>
    @php
        $dashboardRoute = Auth::check() ?
            (Auth::user()->level->level_kode === 'AdmUpa' ? route('admin.dashboard') :
             (Auth::user()->level->level_kode === 'AdmITC' ? route('admin.mahasiswa.index') :
              route('mahasiswa.dashboard'))) :
            route('landing');
    @endphp
    <a class="navbar-brand m-0" href="{{ $dashboardRoute }}">
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
        $isAdmin = in_array($userRole, ['AdmUpa', 'AdmITC']);
        $isAdminUpa = $userRole === 'AdmUpa';
        $isAdminITC = $userRole === 'AdmITC';
        $isStudent = $userRole === 'Mhs';
        $currentUrl = url()->current();
      @endphp

      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'dashboard') !== false ? 'active' : '' }}"
           href="{{ $isAdminUpa ? route('admin.dashboard') : ($isAdminITC ? route('welcome') : route('mahasiswa.dashboard')) }}">
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

      <!-- Student Pendaftaran - Only for Students -->
      @if($isStudent)
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
      @if($isAdminUpa || $isStudent)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'jadwal') !== false ? 'active' : '' }}"
           href="{{ $isAdmin ? route('jadwal.index') : route('mahasiswa.jadwal') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-calendar-alt text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Jadwal</span>
        </a>
      </li>
      @endif

      <!-- Hasil Ujian -->
      @if($isAdminUpa || $isStudent)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'hasil-ujian') !== false || strpos($currentUrl, 'hasil_ujian') !== false ? 'active' : '' }}"
           href="{{ $isAdmin ? route('hasil_ujian.index') : route('mahasiswa.hasil_ujian') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-bar text-info text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Hasil Ujian</span>
        </a>
      </li>
      @endif

      <!-- Surat Pernyataan - Only for AdmUpa and Students -->
      @if($isAdminUpa || $isStudent)
      <li class="nav-item">
        <a class="nav-link {{ strpos($currentUrl, 'surat-pernyataan') !== false ? 'active' : '' }}"
           href="{{ $isAdminUpa ? route('admin.surat-pernyataan.index') : route('mahasiswa.surat-pernyataan.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-file-signature text-danger text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Surat Pernyataan</span>
        </a>
      </li>
      @endif

      <!-- Verifikasi - Only for AdmUpa -->
      @if($isAdminUpa)
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
</style>
