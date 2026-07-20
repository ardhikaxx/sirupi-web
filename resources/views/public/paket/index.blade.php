@extends('layouts.public')

@section('title', 'Paket Pengadaan - SIRUPI')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold mb-1">Paket Pengadaan</h2>
            <p class="text-muted mb-4">Daftar paket pengadaan yang telah dipublikasikan.</p>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('publik.paket.search') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nama paket..." value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="unit_kerja_id" class="form-control">
                                <option value="">Semua Unit</option>
                                @foreach($unitKerjas ?? [] as $uk)
                                    <option value="{{ $uk->id }}" {{ request('unit_kerja_id') == $uk->id ? 'selected' : '' }}>{{ $uk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="tahun" class="form-control">
                                <option value="">Semua Tahun</option>
                                @foreach($tahuns ?? [] as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="jenis_pengadaan_id" class="form-control">
                                <option value="">Jenis</option>
                                @foreach($jenisPengadaans ?? [] as $jp)
                                    <option value="{{ $jp->id }}" {{ request('jenis_pengadaan_id') == $jp->id ? 'selected' : '' }}>{{ $jp->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Kode Paket</th>
                                    <th>Nama Paket</th>
                                    <th>Unit Kerja</th>
                                    <th>Pagu</th>
                                    <th>Jenis Pengadaan</th>
                                    <th class="pe-4">Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pakets ?? [] as $paket)
                                <tr>
                                    <td class="ps-4 font-mono">{{ $paket->kode_paket }}</td>
                                    <td>
                                        <a href="{{ route('publik.paket.show', $paket->id) }}" class="text-decoration-none fw-medium">{{ $paket->nama_paket }}</a>
                                    </td>
                                    <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                                    <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                                    <td>{{ $paket->jenisPengadaan->nama ?? '-' }}</td>
                                    <td class="pe-4">{{ $paket->tahunAnggaran->tahun ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open me-2"></i>Tidak ada paket yang ditemukan.
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
</div>
@endsection
