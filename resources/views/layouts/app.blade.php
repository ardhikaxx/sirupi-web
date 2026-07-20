<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIRUPI')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.11/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css" rel="stylesheet">

    <link href="{{ asset('assets/css/sirupi.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <span>SIRUPI</span>
            </div>

            <ul class="sidebar-nav" id="sidebarMenu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                @if(in_array(auth()->user()->role, ['super_admin', 'admin']))
                <li class="nav-item">
                    <small class="nav-section-title">Master Data</small>
                </li>
                @foreach([
                    ['route' => 'admin.unit-kerja.index', 'icon' => 'fa-building', 'label' => 'Unit Kerja', 'pattern' => 'admin/unit-kerja*'],
                    ['route' => 'admin.user.index', 'icon' => 'fa-users', 'label' => 'Users', 'pattern' => 'admin/user*'],
                    ['route' => 'admin.tahun-anggaran.index', 'icon' => 'fa-calendar', 'label' => 'Tahun Anggaran', 'pattern' => 'admin/tahun-anggaran*'],
                    ['route' => 'admin.program.index', 'icon' => 'fa-book', 'label' => 'Program', 'pattern' => 'admin/program*'],
                    ['route' => 'admin.kegiatan.index', 'icon' => 'fa-tasks', 'label' => 'Kegiatan', 'pattern' => 'admin/kegiatan*'],
                    ['route' => 'admin.sub-kegiatan.index', 'icon' => 'fa-list-check', 'label' => 'Sub Kegiatan', 'pattern' => 'admin/sub-kegiatan*'],
                    ['route' => 'admin.sumber-dana.index', 'icon' => 'fa-money-bill-wave', 'label' => 'Sumber Dana', 'pattern' => 'admin/sumber-dana*'],
                    ['route' => 'admin.jenis-pengadaan.index', 'icon' => 'fa-tag', 'label' => 'Jenis Pengadaan', 'pattern' => 'admin/jenis-pengadaan*'],
                    ['route' => 'admin.metode-pengadaan.index', 'icon' => 'fa-cogs', 'label' => 'Metode Pengadaan', 'pattern' => 'admin/metode-pengadaan*'],
                    ['route' => 'admin.kategori.index', 'icon' => 'fa-layer-group', 'label' => 'Kategori', 'pattern' => 'admin/kategori*'],
                    ['route' => 'admin.satuan.index', 'icon' => 'fa-ruler', 'label' => 'Satuan', 'pattern' => 'admin/satuan*'],
                    ['route' => 'admin.penyedia.index', 'icon' => 'fa-truck', 'label' => 'Penyedia', 'pattern' => 'admin/penyedia*'],
                    ['route' => 'admin.pejabat.index', 'icon' => 'fa-user-tie', 'label' => 'Pejabat', 'pattern' => 'admin/pejabat*'],
                ] as $item)
                <li class="nav-item">
                    <a href="{{ route($item['route']) }}" class="nav-link {{ request()->is($item['pattern']) ? 'active' : '' }}">
                        <i class="fas {{ $item['icon'] }} nav-icon"></i>
                        <span class="nav-text">{{ $item['label'] }}</span>
                    </a>
                </li>
                @endforeach
                <li class="nav-item">
                    <small class="nav-section-title">Lainnya</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.paket.index') }}" class="nav-link {{ request()->is('admin/paket*') ? 'active' : '' }}">
                        <i class="fas fa-box nav-icon"></i>
                        <span class="nav-text">Paket Pengadaan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <span class="nav-text">Laporan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.activity-log') }}" class="nav-link {{ request()->is('admin/activity-log*') ? 'active' : '' }}">
                        <i class="fas fa-history nav-icon"></i>
                        <span class="nav-text">Activity Log</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'operator')
                <li class="nav-item">
                    <small class="nav-section-title">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('operator.paket.index') }}" class="nav-link {{ request()->is('operator/paket*') ? 'active' : '' }}">
                        <i class="fas fa-box nav-icon"></i>
                        <span class="nav-text">Paket Saya</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'verifikator')
                <li class="nav-item">
                    <small class="nav-section-title">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('verifikator.paket.index') }}" class="nav-link {{ request()->is('verifikator/paket*') ? 'active' : '' }}">
                        <i class="fas fa-check-double nav-icon"></i>
                        <span class="nav-text">Verifikasi Paket</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'pimpinan')
                <li class="nav-item">
                    <small class="nav-section-title">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pimpinan.paket.index') }}" class="nav-link {{ request()->is('pimpinan/paket*') ? 'active' : '' }}">
                        <i class="fas fa-file-signature nav-icon"></i>
                        <span class="nav-text">Persetujuan Paket</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'auditor')
                <li class="nav-item">
                    <small class="nav-section-title">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('auditor.paket.index') }}" class="nav-link {{ request()->is('auditor/paket*') ? 'active' : '' }}">
                        <i class="fas fa-folder-open nav-icon"></i>
                        <span class="nav-text">Data Paket</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('auditor.activity-log') }}" class="nav-link {{ request()->is('auditor/activity-log*') ? 'active' : '' }}">
                        <i class="fas fa-history nav-icon"></i>
                        <span class="nav-text">Activity Log</span>
                    </a>
                </li>
                @endif
            </ul>

            <div class="sidebar-footer">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle w-100 d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        <span class="text-truncate">{{ Auth::user()->name ?? 'User' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark w-100">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-id-card me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content" id="mainContent">
            <nav class="navbar-top">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <nav aria-label="breadcrumb" class="flex-grow-1">
                    <ol class="breadcrumb mb-0">
                        @yield('breadcrumb')
                    </ol>
                </nav>
                <div class="navbar-nav-right">
                    <div class="nav-item dropdown">
                        <button class="btn-icon" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="width:300px">
                            <li><h6 class="dropdown-header">Notifikasi</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center text-muted small" href="#">Tidak ada notifikasi</a></li>
                        </ul>
                    </div>
                    <div class="nav-item dropdown">
                        @php
                            $roleLabels = ['super_admin' => 'Super Admin', 'admin' => 'Admin', 'operator' => 'Operator', 'verifikator' => 'Verifikator', 'pimpinan' => 'Pimpinan', 'auditor' => 'Auditor'];
                            $roleColors = ['super_admin' => 'danger', 'admin' => 'primary', 'operator' => 'success', 'verifikator' => 'info', 'pimpinan' => 'warning', 'auditor' => 'secondary'];
                        @endphp
                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <span class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            <span>{{ Auth::user()->name ?? 'User' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-cog me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    @stack('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('assets/js/sirupi.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });

            flatpickr.setDefaults({ locale: 'id', dateFormat: 'd/m/Y' });

            document.querySelectorAll('[data-confirm]').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    const message = this.dataset.confirm || 'Apakah anda yakin?';
                    const href = this.getAttribute('href') || this.dataset.href;
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'Ya, lanjutkan!',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed && href) window.location.href = href;
                    });
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
