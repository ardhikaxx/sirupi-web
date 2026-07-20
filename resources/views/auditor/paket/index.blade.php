@extends('layouts.app')

@section('title', 'Data Paket')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Paket</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-folder-open me-2"></i>Data Paket Pengadaan</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="filterStatus" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="diajukan">Diajukan</option>
                    <option value="diverifikasi">Terverifikasi</option>
                    <option value="dikembalikan">Dikembalikan</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="dipublikasikan">Dipublikasikan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterTahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunAnggarans as $ta)
                        <option value="{{ $ta->tahun }}">{{ $ta->tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterUnit" class="form-control">
                    <option value="">Semua Unit Kerja</option>
                    @foreach($unitKerjas as $uk)
                        <option value="{{ $uk->id }}">{{ $uk->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button id="resetFilter" class="btn btn-secondary w-100"><i class="fas fa-sync me-1"></i>Reset Filter</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="paketTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Paket</th>
                        <th>Nama Paket</th>
                        <th>Unit Kerja</th>
                        <th>Tahun</th>
                        <th>Pagu</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $paket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-mono">{{ $paket->kode_paket }}</td>
                        <td>{{ $paket->nama_paket }}</td>
                        <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                        <td>{{ $paket->tahunAnggaran->tahun ?? '-' }}</td>
                        <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                        <td>{!! statusBadge($paket->status) !!}</td>
                        <td>{{ $paket->user->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('auditor.paket.show', $paket->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-inbox me-2"></i>Tidak ada data paket.
                        </td>
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
    $(document).ready(function() {
        var table = $('#paketTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' },
            order: [[0, 'desc']]
        });

        $('#filterStatus').on('change', function() {
            table.column(6).search(this.value).draw();
        });

        $('#filterTahun').on('change', function() {
            table.column(4).search(this.value).draw();
        });

        $('#filterUnit').on('change', function() {
            table.column(3).search(this.value).draw();
        });

        $('#resetFilter').on('click', function() {
            $('#filterStatus, #filterTahun, #filterUnit').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>
@endpush
