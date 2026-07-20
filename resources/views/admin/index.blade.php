@extends('layouts.app')

@section('title', 'Dashboard - SIRUPI')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h4>
        <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i>{{ date('d F Y') }}</span>
    </div>

    <div class="row g-3 mb-4">
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
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Total Pagu Anggaran</p>
                            <h5 class="mb-0 fw-bold font-mono">{{ isset($totalPagu) ? formatRupiah($totalPagu) : 'Rp0' }}</h5>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-money-bill-wave"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Paket Disetujui</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $paketDisetujui ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75 small">Paket Dipublikasikan</p>
                            <h3 class="mb-0 fw-bold font-mono">{{ $paketDipublikasikan ?? 0 }}</h3>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-globe"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Paket per Status</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="chartStatus" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="card-title fw-bold mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Paket per Unit Kerja</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="chartUnitKerja" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Aktivitas Terbaru</h5>
            <a href="{{ route('admin.activity-log') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body px-0 pb-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Waktu</th>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th class="pe-4">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities ?? [] as $activity)
                            <tr>
                                <td class="ps-4 small">{{ formatTanggal($activity->created_at) }}</td>
                                <td>{{ $activity->user->name ?? '-' }}</td>
                                <td>{{ $activity->description }}</td>
                                <td class="pe-4 text-truncate" style="max-width:200px">{{ $activity->detail ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusLabels = @json($statusLabels ?? ['Draft', 'Diajukan', 'Diverifikasi', 'Disetujui', 'Ditolak', 'Dipublikasikan']);
        const statusData  = @json($statusData ?? [0, 0, 0, 0, 0, 0]);
        const unitLabels  = @json($unitLabels ?? ['Unit Kerja']);
        const unitData    = @json($unitData ?? [1]);

        new Chart(document.getElementById('chartStatus'), {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Jumlah Paket',
                    data: statusData,
                    backgroundColor: ['#6c757d', '#0d6efd', '#ffc107', '#198754', '#dc3545', '#0dcaf0'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        new Chart(document.getElementById('chartUnitKerja'), {
            type: 'doughnut',
            data: {
                labels: unitLabels,
                datasets: [{
                    data: unitData,
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6f42c1', '#fd7e14']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 10 }
                    }
                }
            }
        });
    });
</script>
@endpush
