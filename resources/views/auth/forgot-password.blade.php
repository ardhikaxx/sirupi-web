@extends('layouts.public')

@section('title', 'Lupa Password - SIRUPI')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <span class="display-6 fw-bold text-primary"><i class="fas fa-cubes me-2"></i>SIRUPI</span>
                        </div>

                        <div class="mb-4">
                            <div class="display-1 text-warning mb-3">
                                <i class="fas fa-key"></i>
                            </div>
                            <h4>Lupa Password</h4>
                            <p class="text-muted">
                                Fitur reset password mandiri belum tersedia. Silakan hubungi administrator sistem untuk mereset password Anda.
                            </p>
                        </div>

                        <div class="alert alert-info text-start" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Kontak Administrator:</strong>
                            <hr class="my-2">
                            <p class="mb-1"><i class="fas fa-envelope me-2"></i>admin@sirupi.go.id</p>
                            <p class="mb-0"><i class="fas fa-phone me-2"></i>(021) 1234-5678</p>
                        </div>

                        <div class="d-grid mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Masuk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
