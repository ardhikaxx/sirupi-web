@extends('layouts.app')

@section('title', 'Penyedia')

@php
    $menu = 'admin.penyedia';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Penyedia</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Penyedia</h5>
        <a href="{{ route('admin.penyedia.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Penyedia
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="penyediaTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NPWP</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penyedias as $penyedia)
                    <tr>
                        <td>{{ $penyedia->nama }}</td>
                        <td>{{ $penyedia->npwp ?? '-' }}</td>
                        <td>{{ $penyedia->telepon ?? '-' }}</td>
                        <td>{{ $penyedia->email ?? '-' }}</td>
                        <td>{{ $penyedia->jenis ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.penyedia.show', $penyedia->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.penyedia.edit', $penyedia->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $penyedia->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $penyedia->id }}" action="{{ route('admin.penyedia.destroy', $penyedia->id) }}" method="POST" class="d-none">
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
        $('#penyediaTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus penyedia ini?',
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
