@extends('layouts.app')

@section('title', 'Dashboard - SIRUPI')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Verifikator</h4>
        <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i>{{ date('d F Y') }}</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Menunggu Verifikasi</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $menungguVerifikasi ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-hourglass-half"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Diverifikasi</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $diverifikasi ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-danger text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Dikembalikan</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $dikembalikan ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-undo-alt"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Paket Menunggu Verifikasi</h5>
            <a href="{{ route('verifikator.paket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body px-0 pb-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Paket</th>
                            <th>Unit Kerja</th>
                            <th>Pagu</th>
                            <th>Operator</th>
                            <th class="pe-4">Tanggal Diajukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paketMenunggu ?? [] as $paket)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('verifikator.paket.show', $paket->id) }}" class="text-decoration-none fw-medium">{{ $paket->nama_paket }}</a>
                                </td>
                                <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                                <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                                <td>{{ $paket->user->name ?? '-' }}</td>
                                <td class="pe-4 small">{{ formatTanggal($paket->created_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-check-circle me-2"></i>Tidak ada paket yang menunggu verifikasi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
