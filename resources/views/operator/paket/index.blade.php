@extends('layouts.app')

@section('title', 'Paket Saya')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Paket Saya</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-box me-2"></i>Paket Saya</h4>
    <a href="{{ route('operator.paket.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Buat Paket Baru
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <select id="filterStatus" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="diajukan">Diajukan</option>
                    <option value="diverifikasi">Terverifikasi</option>
                    <option value="dikembalikan">Dikembalikan</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
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
                        <th>Pagu</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $paket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-mono">{{ $paket->kode_paket }}</td>
                        <td>
                            <a href="{{ route('operator.paket.show', $paket->id) }}" class="text-decoration-none fw-medium">{{ $paket->nama_paket }}</a>
                        </td>
                        <td class="font-mono">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                        <td>{!! statusBadge($paket->status) !!}</td>
                        <td>{{ formatTanggal($paket->created_at) }}</td>
                        <td>
                            <a href="{{ route('operator.paket.show', $paket->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(in_array($paket->status, ['draft', 'dikembalikan']))
                                <a href="{{ route('operator.paket.edit', $paket->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $paket->id }}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="hapus-form-{{ $paket->id }}" action="{{ route('operator.paket.destroy', $paket->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-box-open me-2"></i>Belum ada paket.
                            <a href="{{ route('operator.paket.create') }}" class="text-decoration-none">Buat paket baru</a>
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
            table.column(4).search(this.value).draw();
        });

        $('#resetFilter').on('click', function() {
            $('#filterStatus').val('');
            table.search('').columns().search('').draw();
        });

        $('.btn-hapus').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Paket',
                text: 'Apakah anda yakin ingin menghapus paket ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    $('#hapus-form-' + id).submit();
                }
            });
        });
    });
</script>
@endpush
