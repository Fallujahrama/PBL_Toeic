<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

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
        <li class="nav-header">Data Kegiatan</li>
            <li class="nav-item">
                <a href="{{ route('jadwal.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'jadwal') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Jadwal</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('hasil_ujian.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'hasil_ujian') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Hasil Ujian</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('surat_pernyataan.index') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'surat_pernyataan') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Surat Pernyataan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('surat_pernyataan.createMahasiswa') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'upload_surat_pernyataan') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-upload"></i>
                    <p>Upload Surat Pernyataan</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
