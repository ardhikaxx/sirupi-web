@extends('layouts.app')

@section('title', 'Paket Pengadaan')

@php
    $menu = 'paket';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Paket Pengadaan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Paket Pengadaan</h5>
    </div>
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
                        <option value="{{ $ta->id }}">{{ $ta->tahun }} - {{ $ta->nama }}</option>
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
            <table class="table table-bordered table-hover" id="paketTable">
                <thead>
                    <tr>
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
                    @foreach($pakets as $paket)
                    <tr>
                        <td>{{ $paket->kode_paket }}</td>
                        <td>{{ $paket->nama_paket }}</td>
                        <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                        <td>{{ $paket->tahunAnggaran->tahun ?? '-' }}</td>
                        <td>{{ formatRupiah($paket->pagu_anggaran) }}</td>
                        <td>{!! statusBadge($paket->status) !!}</td>
                        <td>{{ $paket->user->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.paket.show', $paket->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($paket->status === 'disetujui' && !$paket->is_published)
                                <button class="btn btn-sm btn-success btn-publikasikan" data-id="{{ $paket->id }}">
                                    <i class="fas fa-globe me-1"></i>Publikasikan
                                </button>
                                <form id="publikasikan-form-{{ $paket->id }}" action="{{ route('admin.paket.publish', $paket->id) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endif
                        </td>
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
        var table = $('#paketTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' },
            order: [[0, 'desc']]
        });

        $('#filterStatus').on('change', function() {
            table.column(5).search(this.value).draw();
        });

        $('#filterTahun').on('change', function() {
            table.column(3).search(this.value).draw();
        });

        $('#filterUnit').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        $('#resetFilter').on('click', function() {
            $('#filterStatus, #filterTahun, #filterUnit').val('');
            table.search('').columns().search('').draw();
        });

        $('.btn-publikasikan').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Publikasikan Paket',
                text: 'Paket yang dipublikasikan akan tampil di halaman publik. Lanjutkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Ya, publikasikan!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    $('#publikasikan-form-' + id).submit();
                }
            });
        });
    });
</script>
@endpush
