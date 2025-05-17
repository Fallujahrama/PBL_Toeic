<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('/') }}">
      <div class="d-flex align-items-center justify-content-center">
        <img src="{{ asset('adminlte/assets/img/logo-ct-dark.png') }}" width="32" height="32" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-2 font-weight-bold">TOEIC Center</span>
      </div>
    </a>
  </div>
  
  <hr class="horizontal dark mt-0">
  
  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pendaftaran*') ? 'active' : '' }}" href="{{ route('pendaftaran.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
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
        <a class="nav-link {{ request()->is('billing') ? 'active' : '' }}" href="{{ url('/billing') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Hasil Ujian</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('virtual-reality') ? 'active' : '' }}" href="{{ url('/virtual-reality') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-app text-info text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Surat Pernyataan</span>
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

      <li class="nav-item">
        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-copy-04 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Sign In</span>
        </a>
      </li>
    </ul>
  </div>
  
    <a class="btn btn-dark btn-sm w-100 mb-3" href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
</aside>
