@extends('layouts.app')

@section('title', 'Sumber Dana')

@php
    $menu = 'admin.sumber-dana';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Sumber Dana</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Sumber Dana</h5>
        <a href="{{ route('admin.sumber-dana.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Sumber Dana
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="sumberDanaTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sumberDanas as $sd)
                    <tr>
                        <td>{{ $sd->kode }}</td>
                        <td>{{ $sd->nama }}</td>
                        <td>
                            <a href="{{ route('admin.sumber-dana.show', $sd->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.sumber-dana.edit', $sd->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $sd->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $sd->id }}" action="{{ route('admin.sumber-dana.destroy', $sd->id) }}" method="POST" class="d-none">
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
        $('#sumberDanaTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus sumber dana ini?',
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
