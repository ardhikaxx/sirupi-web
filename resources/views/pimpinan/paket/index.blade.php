@extends('layouts.app')

@section('title', 'Persetujuan Paket')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Persetujuan Paket</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-file-signature me-2"></i>Persetujuan Paket</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="persetujuanTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Paket</th>
                        <th>Nama Paket</th>
                        <th>Unit Kerja</th>
                        <th>Pagu</th>
                        <th>Status</th>
                        <th>Diverifikasi Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $paket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-mono">{{ $paket->kode_paket }}</td>
                        <td>
                            <a href="{{ route('pimpinan.paket.show', $paket->id) }}" class="text-decoration-none fw-medium">{{ $paket->nama_paket }}</a>
                        </td>
                        <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                        <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                        <td>{!! statusBadge($paket->status) !!}</td>
                        <td>{{ formatTanggal($paket->updated_at) }}</td>
                        <td>
                            <a href="{{ route('pimpinan.paket.show', $paket->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-check-circle me-2"></i>Tidak ada paket yang perlu disetujui.
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
        $('#persetujuanTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' },
            order: [[0, 'desc']]
        });
    });
</script>
@endpush
