@extends('layouts.public')

@section('title', 'Beranda - SIRUPI')

@section('content')
<div class="container">
    <div class="row min-vh-75 align-items-center">
        <div class="col-lg-8 mx-auto text-center py-5">
            <h1 class="display-4 fw-bold mb-3">Selamat Datang di <span class="text-primary">SIRUPI</span></h1>
            <p class="lead text-muted mb-4">Sistem Informasi Rencana Umum Pengadaan Internal — Portal transparansi rencana pengadaan barang dan jasa pemerintah.</p>

            <form action="{{ route('publik.paket.search') }}" method="GET" class="mb-5">
                <div class="input-group input-group-lg shadow-sm">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari paket pengadaan..." value="{{ request('keyword') }}">
                    <button class="btn btn-primary px-4" type="submit"><i class="fas fa-search me-2"></i>Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-1 mb-3"><i class="fas fa-box"></i></div>
                    <h5 class="fw-bold mb-0">{{ $totalPaket ?? 0 }}</h5>
                    <small class="opacity-75">Total Paket Dipublikasikan</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-1 mb-3"><i class="fas fa-money-bill-wave"></i></div>
                    <h5 class="fw-bold mb-0">{{ isset($totalPagu) ? formatRupiah($totalPagu) : 'Rp0' }}</h5>
                    <small class="opacity-75">Total Pagu Anggaran</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="fs-1 mb-3"><i class="fas fa-building"></i></div>
                    <h5 class="fw-bold mb-0">{{ $totalUnitKerja ?? 0 }}</h5>
                    <small class="opacity-75">Unit Kerja</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Paket Terbaru</h5>
            <a href="{{ route('publik.paket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body px-0 pb-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Kode Paket</th>
                            <th>Nama Paket</th>
                            <th>Unit Kerja</th>
                            <th>Pagu</th>
                            <th class="pe-4">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPakets ?? [] as $paket)
                        <tr>
                            <td class="ps-4 font-mono">{{ $paket->kode_paket }}</td>
                            <td>
                                <a href="{{ route('publik.paket.show', $paket->id) }}" class="text-decoration-none fw-medium">{{ $paket->nama_paket }}</a>
                            </td>
                            <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                            <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                            <td class="pe-4">{{ $paket->tahunAnggaran->tahun ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-box-open me-2"></i>Belum ada paket yang dipublikasikan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <form action="{{ route('publik.paket.search') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kata Kunci</label>
                    <input type="text" name="keyword" class="form-control" placeholder="Nama paket...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Unit Kerja</label>
                    <select name="unit_kerja_id" class="form-control">
                        <option value="">Semua Unit</option>
                        @foreach($unitKerjas ?? [] as $uk)
                            <option value="{{ $uk->id }}">{{ $uk->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tahun</label>
                    <select name="tahun" class="form-control">
                        <option value="">Semua Tahun</option>
                        @foreach($tahuns ?? [] as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
