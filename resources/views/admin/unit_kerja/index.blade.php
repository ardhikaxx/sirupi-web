@extends('layouts.app')

@section('title', 'Unit Kerja')

@php
    $menu = 'admin.unit-kerja';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Unit Kerja</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Unit Kerja</h5>
        <a href="{{ route('admin.unit-kerja.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Unit Kerja
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="unitKerjaTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unitKerjas as $unitKerja)
                    <tr>
                        <td>{{ $unitKerja->kode }}</td>
                        <td>{{ $unitKerja->nama }}</td>
                        <td>{{ $unitKerja->telepon ?? '-' }}</td>
                        <td>{{ $unitKerja->email ?? '-' }}</td>
                        <td>
                            @if($unitKerja->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.unit-kerja.show', $unitKerja->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.unit-kerja.edit', $unitKerja->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $unitKerja->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $unitKerja->id }}" action="{{ route('admin.unit-kerja.destroy', $unitKerja->id) }}" method="POST" class="d-none">
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
        $('#unitKerjaTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus unit kerja ini?',
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
