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
      <li class="nav-item">
        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('pendaftaran*') ? 'active' : '' }}" href="{{ route('pendaftaran.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Pendaftaran</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('jadwal*') ? 'active' : '' }}" href="{{ route('jadwal.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Jadwal</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('hasil_ujian*') ? 'active' : '' }}" href="{{ route('hasil_ujian.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-collection text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Hasil Ujian</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('verifikasi*') ? 'active' : '' }}" href="{{ route('verifikasi.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-check-bold text-info text-sm opacity-10"></i>
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

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ url('/profile') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      
    </ul>
  </div>
  
  <div class="sidenav-footer mx-3 mt-3">
    <a class="btn btn-primary btn-sm w-100 mb-3" href="{{ url('/') }}">
      <i class="fas fa-home me-2"></i> Dashboard
    </a>
    <a class="btn btn-dark btn-sm w-100 mb-3" href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fas fa-sign-out-alt me-2"></i> Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
</aside>
