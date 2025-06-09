@php
use App\Models\NotifikasiModel;
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{ \App\Models\NotifikasiModel::count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @foreach (\App\Models\NotifikasiModel::latest()->take(5)->get() as $notification)
                <a href="{{ route('notifications.show', $notification->id) }}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> {{ $notification->pesan }}
                    <span class="float-right text-muted text-sm">{{ $notification->tanggal }}</span>
                </a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
        </div>
    </li>
      <!-- User profile dropdown -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img
            src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('img/default-profile.png') }}"
            class="user-image img-circle elevation-1" alt="User Image">
          <span class="d-none d-md-inline">{{ auth()->user()->nama }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img
              src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('img/default-profile.png') }}"
              class="img-circle elevation-2" alt="User Image">
            <p>
              {{ auth()->user()->nama }}
              <small>{{ auth()->user()->level->level_nama ?? 'User' }}</small>
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="{{ url('/profile') }}" class="btn btn-secondary btn-flat">Profil</a>
            <a href="#" class="btn btn-warning btn-flat float-right"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
