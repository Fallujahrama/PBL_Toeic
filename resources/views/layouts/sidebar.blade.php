<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('/') }}">
      <div class="d-flex align-items-center justify-content-center">
        <div class="icon-shape icon-sm bg-gradient-primary text-white rounded-circle shadow">
          <i class="fas fa-language"></i>
        </div>
        <span class="ms-2 font-weight-bold">TOEIC Center</span>
      </div>
    </a>
  </div>

  <hr class="horizontal dark mt-0">

  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      @php
        $userRole = Auth::user()->level->level_kode ?? null;
        $isAdmin = in_array($userRole, ['AdmUpa', 'AdmITC']);
        $isStudent = $userRole === 'Mhs';
      @endphp

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/dashboard') || request()->is('mahasiswa/dashboard') ? 'active' : '' }}"
           href="{{ $isAdmin ? route('admin.dashboard') : route('mahasiswa.dashboard') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      @if(!$isAdmin)
      <li class="nav-item">
        <a class="nav-link {{ request()->is('*pendaftaran*') ? 'active' : '' }}" href="{{ route('pendaftaran.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-clipboard-list text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Pendaftaran</span>
        </a>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*jadwal*') ? 'active' : '' }}"
           href="{{ $isAdmin ? route('jadwal.index') : route('mahasiswa.jadwal') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-calendar-alt text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Jadwal</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*hasil-ujian*') || request()->is('*hasil_ujian*') ? 'active' : '' }}"
           href="{{ $isAdmin ? route('hasil_ujian.index') : route('mahasiswa.hasil_ujian') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-bar text-info text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Hasil Ujian</span>
        </a>
      </li>

      @if($isAdmin)
      <li class="nav-item">
        <a class="nav-link {{ request()->is('*verifikasi*') ? 'active' : '' }}" href="{{ route('verifikasi.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-check-circle text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Verifikasi</span>

          @php
            // Count pending verifications
            $pendingCount = App\Models\PendaftaranModel::where('status_verifikasi', 'pending')
                ->orWhereNull('status_verifikasi')
                ->count();
          @endphp

          @if($pendingCount > 0)
            <span class="verification-badge">{{ $pendingCount }}</span>
          @endif
        </a>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*notifikasi*') ? 'active' : '' }}"
           href="{{ $isAdmin ? route('notifikasi.index') : route('mahasiswa.notifikasi') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-bell text-danger text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Notifikasi</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-circle text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Profil</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-sign-out-alt text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
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
    <a href="{{ $isAdmin ? route('admin.dashboard') : route('mahasiswa.dashboard') }}" class="btn btn-primary btn-sm w-100 mb-3">
      <i class="fas fa-home me-2"></i> Dashboard
    </a>
    <a class="btn btn-dark btn-sm w-100" href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form-footer').submit();">
      <i class="fas fa-sign-out-alt me-2"></i> Logout
    </a>
    <form id="logout-form-footer" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
</aside>
