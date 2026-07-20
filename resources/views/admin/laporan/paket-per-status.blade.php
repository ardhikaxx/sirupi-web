@extends('layouts.app')

@section('title', 'Paket per Status')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Paket per Status</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold"><i class="fas fa-tags me-2"></i>Paket per Status</h4>
    <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i>Tahun Anggaran: {{ $tahun }}</span>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Data Paket per Status</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Total Pagu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{!! statusBadge($item->status) !!}</td>
                        <td class="text-end">{{ $item->total ?? 0 }}</td>
                        <td class="text-end font-mono">{{ formatRupiah($item->total_pagu ?? 0) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
