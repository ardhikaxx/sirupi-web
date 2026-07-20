@extends('layouts.app')

@section('title', 'Jenis Pengadaan')

@php
    $menu = 'admin.jenis-pengadaan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Jenis Pengadaan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Jenis Pengadaan</h5>
        <a href="{{ route('admin.jenis-pengadaan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Jenis Pengadaan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="jenisPengadaanTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisPengadaans as $jp)
                    <tr>
                        <td>{{ $jp->kode }}</td>
                        <td>{{ $jp->nama }}</td>
                        <td>
                            <a href="{{ route('admin.jenis-pengadaan.show', $jp->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.jenis-pengadaan.edit', $jp->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $jp->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $jp->id }}" action="{{ route('admin.jenis-pengadaan.destroy', $jp->id) }}" method="POST" class="d-none">
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
        $('#jenisPengadaanTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus jenis pengadaan ini?',
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
