<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'dashboard')? 'active' : '' }} ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-header">Data Pengguna</li>
        <li class="nav-item">
            <a href="{{ url('/profile') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'profile') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
            </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ url('/pendaftaran') }}" class="nav-link {{ isset($activeMenu) && $activeMenu == 'pendaftaran' ? 'active' : '' }} ">
            <i class="nav-icon fas  fas fa-edit"></i>
            <p>Pendaftaran Mahasiswa</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/hasil-ujian') }}" class="nav-link {{ isset($activeMenu) && $activeMenu == 'hasil_ujian' ? 'active' : '' }}">
            <i class="nav-icon far fa-file-alt"></i>
            <p>Melihat hasil ujian</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/data_mahasiswa') }}" class="nav-link {{ isset($activeMenu) && $activeMenu == 'data_pendaftar' ? 'active' : '' }} ">
            <i class="nav-icon far fa-address-book"></i>
            <p>Data Mahasiswa</p>
          </a>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>