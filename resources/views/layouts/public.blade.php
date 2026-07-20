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
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <link href="{{ asset('assets/css/sirupi.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <header class="bg-white shadow-sm">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between py-3">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <span class="fs-3 fw-bold text-dark"><i class="fas fa-cubes text-primary me-2"></i>SIRUPI</span>
                    <small class="text-muted d-none d-md-inline ms-2">Sistem Informasi Rencana Umum Pengadaan Internal</small>
                </a>
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sign-in-alt me-1"></i>Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow-1 d-flex align-items-center">
        @yield('content')
    </main>

    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-1 text-muted small">
                &copy; {{ date('Y') }} <strong>SIRUPI</strong> - Sistem Informasi Rencana Umum Pengadaan Internal
            </p>
            <p class="mb-0 text-muted small">
                Dikembangkan oleh Bagian Pengadaan Barang dan Jasa
            </p>
        </div>
    </footer>

    @stack('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('assets/js/sirupi.js') }}"></script>

    @stack('scripts')
</body>
</html>
