@extends('layouts.app')

@section('title', 'Rekap Anggaran per Unit')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Rekap Anggaran</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold"><i class="fas fa-money-bill-wave me-2"></i>Rekap Anggaran per Unit</h4>
    <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i>Tahun Anggaran: {{ $tahun }}</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
            <div class="card-body p-4">
                <p class="mb-1 opacity-75 small">Total Pagu</p>
                <h4 class="mb-0 fw-bold font-mono">{{ formatRupiah($data->total_pagu ?? 0) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
            <div class="card-body p-4">
                <p class="mb-1 opacity-75 small">Total HPS</p>
                <h4 class="mb-0 fw-bold font-mono">{{ formatRupiah($data->total_hps ?? 0) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-info text-white">
            <div class="card-body p-4">
                <p class="mb-1 opacity-75 small">Total Paket</p>
                <h4 class="mb-0 fw-bold font-mono">{{ $data->total_paket ?? 0 }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Rekap per Unit Kerja</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Kerja</th>
                        <th class="text-end">Total Paket</th>
                        <th class="text-end">Total Pagu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perUnit as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->unitKerja->nama ?? '-' }}</td>
                        <td class="text-end">{{ $item->total_paket }}</td>
                        <td class="text-end font-mono">{{ formatRupiah($item->total_pagu) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="2" class="text-end">Total</td>
                        <td class="text-end">{{ $perUnit->sum('total_paket') }}</td>
                        <td class="text-end font-mono">{{ formatRupiah($perUnit->sum('total_pagu')) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
