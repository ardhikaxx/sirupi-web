@extends('layouts.app')

@section('title', 'Dashboard - SIRUPI')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Pimpinan</h4>
        <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i>{{ date('d F Y') }}</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Menunggu Persetujuan</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $menungguPersetujuan ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-hourglass-half"></i></div>
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
                            <h3 class="mb-0 fw-bold font-mono">{{ $disetujui ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-danger text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Ditolak</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $ditolak ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-times-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Total Paket</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $totalPaket ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-box"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-1">Total Pagu Anggaran</p>
                    <h4 class="fw-bold font-mono text-primary">{{ isset($totalPagu) ? formatRupiah($totalPagu) : 'Rp0' }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <p class="text-muted mb-1 small">Rata-rata Pagu</p>
                            <h6 class="fw-bold font-mono mb-0">{{ isset($rataPagu) ? formatRupiah($rataPagu) : 'Rp0' }}</h6>
                        </div>
                        <div class="col-4 border-end">
                            <p class="text-muted mb-1 small">Paket Disetujui</p>
                            <h6 class="fw-bold mb-0">{{ $disetujui ?? 0 }} <small class="text-success">({{ isset($totalPaket) && $totalPaket > 0 ? round(($disetujui ?? 0) / $totalPaket * 100) : 0 }}%)</small></h6>
                        </div>
                        <div class="col-4">
                            <p class="text-muted mb-1 small">Nilai Disetujui</p>
                            <h6 class="fw-bold font-mono mb-0">{{ isset($nilaiDisetujui) ? formatRupiah($nilaiDisetujui) : 'Rp0' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Paket per Status</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="chartStatus" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Menunggu Persetujuan</h5>
                    <a href="{{ route('pimpinan.paket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Paket</th>
                                    <th>Pagu</th>
                                    <th class="pe-4">Unit Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paketMenunggu ?? [] as $paket)
                                    <tr>
                                        <td class="ps-4">
                                            <a href="{{ route('pimpinan.paket.show', $paket->id) }}" class="text-decoration-none fw-medium">{{ $paket->nama_paket }}</a>
                                        </td>
                                        <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                                        <td class="pe-4">{{ $paket->unitKerja->nama ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-check-circle me-2"></i>Tidak ada paket menunggu persetujuan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = {{ json_encode($statusLabels ?? ['Draft', 'Diajukan', 'Disetujui', 'Ditolak']) }};
        const data   = {{ json_encode($statusData ?? [0, 0, 0, 0]) }};

        new Chart(document.getElementById('chartStatus'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#6c757d', '#ffc107', '#198754', '#dc3545'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 12 }
                    }
                }
            }
        });
    });
</script>
@endpush
