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

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Data Pengguna -->
            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'profile') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profile</p>
                </a>

                <!-- jadwal -->
            <li class="nav-header">Jadwal</li>
            <li class="nav-item">
                <a href="{{ url('/jadwal') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'jadwal') ? 'active' : ''}}">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Lihat Jadwal</p>
                </a>
            </li>

            <!-- jadwal mhs -->
            <li class="nav-header">Jadwal mhs</li>
            <li class="nav-item">
                <a href="{{ url('/mahasiswa/jadwal') }}" class="nav-link {{ (isset($activeMenu) && $activeMenu == 'jadwal') ? 'active' : ''}}">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>jadwal saya</p>
                </a>
            </li>
        </ul>
    </nav>
</div>