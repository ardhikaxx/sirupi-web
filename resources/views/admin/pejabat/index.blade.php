@extends('layouts.app')

@section('title', 'Pejabat')

@php
    $menu = 'admin.pejabat';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pejabat</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pejabat</h5>
        <a href="{{ route('admin.pejabat.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Pejabat
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="pejabatTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Tipe</th>
                        <th>Unit Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pejabats as $pejabat)
                    <tr>
                        <td>{{ $pejabat->nama }}</td>
                        <td>{{ $pejabat->nip ?? '-' }}</td>
                        <td>{{ $pejabat->jabatan ?? '-' }}</td>
                        <td>
                            @php
                                $tipeColors = ['PPTK' => 'info', 'PP' => 'primary', 'PA_KPA' => 'success'];
                            @endphp
                            <span class="badge bg-{{ $tipeColors[$pejabat->tipe] ?? 'secondary' }}">{{ $pejabat->tipe }}</span>
                        </td>
                        <td>{{ $pejabat->unitKerja->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.pejabat.show', $pejabat->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.pejabat.edit', $pejabat->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $pejabat->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $pejabat->id }}" action="{{ route('admin.pejabat.destroy', $pejabat->id) }}" method="POST" class="d-none">
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
        $('#pejabatTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus pejabat ini?',
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
