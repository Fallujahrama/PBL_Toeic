@php
    use App\Models\NotifikasiModel;
@endphp

<!-- Navbar Material Dashboard -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-3">
    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      @include('layouts.breadcrumb')
    </nav>

    <ul class="navbar-nav justify-content-end align-items-center">

      {{-- Notifikasi --}}
      <li class="nav-item dropdown me-3">
        <a class="nav-link text-body p-0 position-relative" id="dropdownNotifikasi" data-bs-toggle="dropdown" href="#" role="button">
          <div class="icon-button">
            <i class="far fa-bell"></i>
            @php $jumlahNotif = NotifikasiModel::count(); @endphp
            @if ($jumlahNotif > 0)
              <span class="notification-badge">{{ $jumlahNotif }}</span>
            @endif
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n2 dropdown-notification" aria-labelledby="dropdownNotifikasi">
          <li class="dropdown-header">Notifikasi Terbaru</li>
          <div class="notification-list">
            @foreach (NotifikasiModel::latest()->take(5)->get() as $notification)
              <li class="notification-item">
                <a class="dropdown-item border-radius-md" href="{{ route('notifications.show', $notification->id) }}">
                  <div class="d-flex py-1">
                    <div class="notification-icon">
                      <i class="fas fa-bell"></i>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="notification-message">{{ Str::limit($notification->pesan, 50) }}</h6>
                      <p class="notification-date">{{ $notification->tanggal }}</p>
                    </div>
                  </div>
                </a>
              </li>
            @endforeach
          </div>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item text-center view-all" href="{{ route('notifications.index') }}">
              <i class="fas fa-list me-1"></i> Lihat Semua Notifikasi
            </a>
          </li>
        </ul>
      </li>

      {{-- Profil Pengguna --}}
      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="user-avatar">
            <img
              src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('img/default-profile.png') }}"
              alt="User Image">
          </div>
          <span class="d-none d-lg-inline ms-2 user-name">{{ auth()->user()->nama }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-user">
          <li class="dropdown-header">
            <div class="user-header">
              <div class="user-header-avatar">
                <img
                  src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('img/default-profile.png') }}"
                  alt="User Image">
              </div>
              <div class="user-header-info">
                <strong>{{ auth()->user()->nama }}</strong>
                <small>{{ auth()->user()->level->level_nama ?? 'User' }}</small>
              </div>
            </div>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="{{ url('/profile') }}">
              <i class="fas fa-user me-2"></i> Profile
            </a>
          </li>
          <li>
            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </li>

    </ul>
  </div>
</nav>
