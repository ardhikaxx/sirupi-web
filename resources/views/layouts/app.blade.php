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
    <div class="d-flex" id="wrapper">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark" id="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-brand d-flex align-items-center mb-3 text-white text-decoration-none">
                <span class="fs-4 fw-bold"><i class="fas fa-cubes me-2"></i>SIRUPI</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>

                @if(in_array(auth()->user()->role, ['super_admin', 'admin']))
                <li class="nav-item mt-2">
                    <small class="text-secondary text-uppercase px-3 fw-semibold">Master Data</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.unit-kerja.index') }}" class="nav-link text-white {{ request()->is('admin/unit-kerja*') ? 'active' : '' }}">
                        <i class="fas fa-building me-2"></i>Unit Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}" class="nav-link text-white {{ request()->is('admin/user*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i>Users
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tahun-anggaran.index') }}" class="nav-link text-white {{ request()->is('admin/tahun-anggaran*') ? 'active' : '' }}">
                        <i class="fas fa-calendar me-2"></i>Tahun Anggaran
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.program.index') }}" class="nav-link text-white {{ request()->is('admin/program*') ? 'active' : '' }}">
                        <i class="fas fa-book me-2"></i>Program
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.kegiatan.index') }}" class="nav-link text-white {{ request()->is('admin/kegiatan*') ? 'active' : '' }}">
                        <i class="fas fa-tasks me-2"></i>Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sub-kegiatan.index') }}" class="nav-link text-white {{ request()->is('admin/sub-kegiatan*') ? 'active' : '' }}">
                        <i class="fas fa-list-check me-2"></i>Sub Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sumber-dana.index') }}" class="nav-link text-white {{ request()->is('admin/sumber-dana*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave me-2"></i>Sumber Dana
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jenis-pengadaan.index') }}" class="nav-link text-white {{ request()->is('admin/jenis-pengadaan*') ? 'active' : '' }}">
                        <i class="fas fa-tag me-2"></i>Jenis Pengadaan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.metode-pengadaan.index') }}" class="nav-link text-white {{ request()->is('admin/metode-pengadaan*') ? 'active' : '' }}">
                        <i class="fas fa-cogs me-2"></i>Metode Pengadaan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.kategori.index') }}" class="nav-link text-white {{ request()->is('admin/kategori*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group me-2"></i>Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.satuan.index') }}" class="nav-link text-white {{ request()->is('admin/satuan*') ? 'active' : '' }}">
                        <i class="fas fa-ruler me-2"></i>Satuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.penyedia.index') }}" class="nav-link text-white {{ request()->is('admin/penyedia*') ? 'active' : '' }}">
                        <i class="fas fa-truck me-2"></i>Penyedia
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pejabat.index') }}" class="nav-link text-white {{ request()->is('admin/pejabat*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie me-2"></i>Pejabat
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <small class="text-secondary text-uppercase px-3 fw-semibold">Lainnya</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.paket.index') }}" class="nav-link text-white {{ request()->is('admin/paket*') ? 'active' : '' }}">
                        <i class="fas fa-box me-2"></i>Paket Pengadaan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link text-white {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar me-2"></i>Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.activity-log') }}" class="nav-link text-white {{ request()->is('admin/activity-log*') ? 'active' : '' }}">
                        <i class="fas fa-history me-2"></i>Activity Log
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'operator')
                <li class="nav-item mt-2">
                    <small class="text-secondary text-uppercase px-3 fw-semibold">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('operator.paket.index') }}" class="nav-link text-white {{ request()->is('operator/paket*') ? 'active' : '' }}">
                        <i class="fas fa-box me-2"></i>Paket Saya
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'verifikator')
                <li class="nav-item mt-2">
                    <small class="text-secondary text-uppercase px-3 fw-semibold">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('verifikator.paket.index') }}" class="nav-link text-white {{ request()->is('verifikator/paket*') ? 'active' : '' }}">
                        <i class="fas fa-check-double me-2"></i>Verifikasi Paket
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'pimpinan')
                <li class="nav-item mt-2">
                    <small class="text-secondary text-uppercase px-3 fw-semibold">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pimpinan.paket.index') }}" class="nav-link text-white {{ request()->is('pimpinan/paket*') ? 'active' : '' }}">
                        <i class="fas fa-file-signature me-2"></i>Persetujuan Paket
                    </a>
                </li>
                @endif

                @if(auth()->user()->role === 'auditor')
                <li class="nav-item mt-2">
                    <small class="text-secondary text-uppercase px-3 fw-semibold">Menu</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('auditor.paket.index') }}" class="nav-link text-white {{ request()->is('auditor/paket*') ? 'active' : '' }}">
                        <i class="fas fa-folder-open me-2"></i>Data Paket
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('auditor.activity-log') }}" class="nav-link text-white {{ request()->is('auditor/activity-log*') ? 'active' : '' }}">
                        <i class="fas fa-history me-2"></i>Activity Log
                    </a>
                </li>
                @endif
            </ul>
            <hr>
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

        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 py-2 sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-sm btn-outline-secondary me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <nav aria-label="breadcrumb" class="flex-grow-1">
                        <ol class="breadcrumb mb-0">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary position-relative" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="width:300px">
                                <li><h6 class="dropdown-header">Notifikasi</h6></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center text-muted small" href="#">Tidak ada notifikasi</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            @php
                                $roleLabels = ['super_admin' => 'Super Admin', 'admin' => 'Admin', 'operator' => 'Operator', 'verifikator' => 'Verifikator', 'pimpinan' => 'Pimpinan', 'auditor' => 'Auditor'];
                                $roleColors = ['super_admin' => 'danger', 'admin' => 'primary', 'operator' => 'success', 'verifikator' => 'info', 'pimpinan' => 'warning', 'auditor' => 'secondary'];
                            @endphp
                            <button class="btn btn-sm dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                <span class="badge bg-{{ $roleColors[Auth::user()->role] ?? 'secondary' }} me-2">{{ $roleLabels[Auth::user()->role] ?? Auth::user()->role }}</span>
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
                </div>
            </nav>

            <div class="container-fluid p-4">
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
            const wrapper = document.getElementById('wrapper');

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                wrapper.classList.toggle('sidebar-collapsed');
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
