@extends('layouts.app')

@section('title', 'Tahun Anggaran')

@php
    $menu = 'admin.tahun-anggaran';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tahun Anggaran</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Tahun Anggaran</h5>
        <a href="{{ route('admin.tahun-anggaran.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Tahun Anggaran
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tahunAnggaranTable">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Nama</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahunAnggarans as $ta)
                    <tr>
                        <td>{{ $ta->tahun }}</td>
                        <td>{{ $ta->nama }}</td>
                        <td>{{ formatTanggal($ta->tanggal_mulai) }}</td>
                        <td>{{ formatTanggal($ta->tanggal_selesai) }}</td>
                        <td>
                            @if($ta->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if(!$ta->is_active)
                                <button class="btn btn-sm btn-success btn-aktifkan" data-id="{{ $ta->id }}">
                                    <i class="fas fa-check me-1"></i>Aktifkan
                                </button>
                                <form id="aktifkan-form-{{ $ta->id }}" action="{{ route('admin.tahun-anggaran.set-active', $ta->id) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endif
                            <a href="{{ route('admin.tahun-anggaran.show', $ta->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.tahun-anggaran.edit', $ta->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $ta->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $ta->id }}" action="{{ route('admin.tahun-anggaran.destroy', $ta->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
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
        $('#tahunAnggaranTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus tahun anggaran ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    $('#delete-form-' + id).submit();
                }
            });
        });

        $('.btn-aktifkan').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Aktifkan tahun anggaran ini? Tahun anggaran aktif lainnya akan dinonaktifkan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Ya, aktifkan!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    $('#aktifkan-form-' + id).submit();
                }
            });
        });
    });
</script>
@endpush
