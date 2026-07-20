@extends('layouts.app')

@section('title', 'Laporan')

@php
    $menu = 'laporan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tahun Anggaran</label>
                <select name="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunAnggarans as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun') == $ta->id ? 'selected' : '' }}>{{ $ta->tahun }} - {{ $ta->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Unit Kerja</label>
                <select name="unit_kerja" class="form-control">
                    <option value="">Semua Unit</option>
                    @foreach($unitKerjas as $uk)
                        <option value="{{ $uk->id }}" {{ request('unit_kerja') == $uk->id ? 'selected' : '' }}>{{ $uk->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="dipublikasikan" {{ request('status') == 'dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i>Tampilkan</button>
                <a href="{{ route('admin.laporan.pdf', request()->all()) }}" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i>PDF
                </a>
                <a href="{{ route('admin.laporan.excel', request()->all()) }}" class="btn btn-success" target="_blank">
                    <i class="fas fa-file-excel me-1"></i>Excel
                </a>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h6 class="card-title">Total Paket</h6>
                <h3 class="mb-0">{{ $totalPaket }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h6 class="card-title">Draft</h6>
                <h3 class="mb-0">{{ $totalDraft }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h6 class="card-title">Disetujui</h6>
                <h3 class="mb-0">{{ $totalDisetujui }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info mb-3">
            <div class="card-body">
                <h6 class="card-title">Dipublikasikan</h6>
                <h3 class="mb-0">{{ $totalDipublikasikan }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Ringkasan Data</h6></div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Total Pagu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ringkasanStatus as $rs)
                <tr>
                    <td>{!! statusBadge($rs->status) !!}</td>
                    <td>{{ $rs->total }}</td>
                    <td>{{ formatRupiah($rs->total_pagu) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Grafik</h6></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="paguChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h6 class="mb-0">Tabel Detail</h6></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="laporanTable">
                <thead>
                    <tr>
                        <th>Kode Paket</th>
                        <th>Nama Paket</th>
                        <th>Unit Kerja</th>
                        <th>Tahun</th>
                        <th>Pagu</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pakets as $paket)
                    <tr>
                        <td>{{ $paket->kode_paket }}</td>
                        <td>{{ $paket->nama_paket }}</td>
                        <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                        <td>{{ $paket->tahunAnggaran->tahun ?? '-' }}</td>
                        <td>{{ formatRupiah($paket->pagu_anggaran) }}</td>
                        <td>{!! statusBadge($paket->status) !!}</td>
                        <td>{{ formatTanggal($paket->created_at) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#laporanTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' },
            order: [[0, 'desc']]
        });

        var statusLabels = {{ json_encode($ringkasanStatus->pluck('status')->map(function($s) {
            $labels = ['draft' => 'Draft', 'diajukan' => 'Diajukan', 'diverifikasi' => 'Terverifikasi', 'dikembalikan' => 'Dikembalikan', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'dipublikasikan' => 'Dipublikasikan'];
            return $labels[$s] ?? $s;
        })->values()) }};
        var statusData = {{ json_encode($ringkasanStatus->pluck('total')) }};
        var paguData = {{ json_encode($ringkasanStatus->pluck('total_pagu')) }};

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{ data: statusData, backgroundColor: ['#6c757d', '#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#212529'] }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Jumlah Paket per Status' } } }
        });

        new Chart(document.getElementById('paguChart'), {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{ label: 'Total Pagu', data: paguData, backgroundColor: ['#6c757d', '#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#212529'] }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, title: { display: true, text: 'Total Pagu per Status' } },
                scales: { y: { beginAtZero: true, ticks: { callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } } } }
            }
        });
    });
</script>
@endpush
