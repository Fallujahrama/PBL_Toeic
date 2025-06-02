@php
    use App\Models\NotifikasiModel;
@endphp

<!-- Navbar Material Dashboard -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-3">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      @if(isset($breadcrumb) && isset($breadcrumb->list))
        <div class="d-flex justify-content-between align-items-center">
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
            <h6 class="font-weight-bolder mb-0">{{ $breadcrumb->title ?? 'Dashboard' }}</h6>
        </div>
      @else
        <h6 class="font-weight-bolder mb-0">Dashboard</h6>
      @endif
    </nav>

    <ul class="navbar-nav justify-content-end align-items-center">

      {{-- Notifikasi --}}
      <li class="nav-item dropdown me-3">
        <a class="nav-link text-body p-0 position-relative" id="dropdownNotifikasi" data-bs-toggle="dropdown" aria-expanded="false">
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
            {{-- <a class="dropdown-item text-center view-all" href="{{ route('notifikasi.index') }}">
              <i class="fas fa-list me-1"></i> Lihat Semua Notifikasi
            </a> --}}
            @php
                // Tentukan route berdasarkan role pengguna
                $user = auth()->user(); // Ambil user yang sedang login
                $notifikasiRoute = auth()->check() && $user && $user->hasRole('Mhs')
                    ? route('mahasiswa.notifikasi.index')
                    : route('notifikasi.index');
            @endphp
            <a class="dropdown-item text-center view-all" href="{{ $notifikasiRoute }}">
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
              src="{{ auth()->check() && auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('img/default-profile.png') }}"
              alt="User Image">
          </div>
          <span class="d-none d-lg-inline ms-2 user-name">
            {{ auth()->check() ? auth()->user()->username : 'Guest' }}
          </span>
        </a>
        @if(auth()->check())
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
        @endif
      </li>

    </ul>
  </div>
</nav>
