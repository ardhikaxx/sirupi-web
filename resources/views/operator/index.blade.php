@extends('layouts.app')

@section('title', 'Dashboard - SIRUPI')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Operator</h4>
        <div>
            <a href="{{ route('operator.paket.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Buat Paket Baru
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Paket Saya</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $totalPaketSaya ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-box"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-secondary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Draft</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $paketDraft ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-pen"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Diajukan</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $paketDiajukan ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-paper-plane"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Disetujui</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $paketDisetujui ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Paket Terbaru Saya</h5>
            <a href="{{ route('operator.paket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body px-0 pb-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Paket</th>
                            <th>Pagu</th>
                            <th>Status</th>
                            <th class="pe-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paketTerbaru ?? [] as $paket)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('operator.paket.show', $paket->id) }}" class="text-decoration-none fw-medium">{{ $paket->nama_paket }}</a>
                                </td>
                                <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                                <td>{!! statusBadge($paket->status) !!}</td>
                                <td class="pe-4 small">{{ formatTanggal($paket->created_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-box-open me-2"></i>Belum ada paket. <a href="{{ route('operator.paket.create') }}" class="text-decoration-none">Buat paket baru</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pb-4 px-4">
            <a href="{{ route('operator.paket.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Buat Paket Baru
            </a>
        </div>
    </div>
@endsection
