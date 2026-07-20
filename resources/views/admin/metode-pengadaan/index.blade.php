@extends('layouts.app')

@section('title', 'Metode Pengadaan')

@php
    $menu = 'admin.metode-pengadaan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Metode Pengadaan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Metode Pengadaan</h5>
        <a href="{{ route('admin.metode-pengadaan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Metode Pengadaan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="metodePengadaanTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metodePengadaans as $mp)
                    <tr>
                        <td>{{ $mp->kode }}</td>
                        <td>{{ $mp->nama }}</td>
                        <td>{{ Str::limit($mp->keterangan, 50) ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.metode-pengadaan.show', $mp->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.metode-pengadaan.edit', $mp->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $mp->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $mp->id }}" action="{{ route('admin.metode-pengadaan.destroy', $mp->id) }}" method="POST" class="d-none">
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
        $('#metodePengadaanTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus metode pengadaan ini?',
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
    });
</script>
@endpush
