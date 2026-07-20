@extends('layouts.app')

@section('title', 'Users')

@php
    $menu = 'admin.user';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Users</h5>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="userTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Role</th>
                        <th>Unit Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nip ?? '-' }}</td>
                        <td>
                            @php
                                $roleColors = [
                                    'super_admin' => 'danger',
                                    'admin' => 'primary',
                                    'operator' => 'success',
                                    'verifikator' => 'info',
                                    'pimpinan' => 'warning',
                                    'auditor' => 'secondary',
                                ];
                                $roleLabels = [
                                    'super_admin' => 'Super Admin',
                                    'admin' => 'Admin',
                                    'operator' => 'Operator',
                                    'verifikator' => 'Verifikator',
                                    'pimpinan' => 'Pimpinan',
                                    'auditor' => 'Auditor',
                                ];
                            @endphp
                            <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->unitKerja->nama ?? '-' }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-none">
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
        $('#userTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin menghapus user ini?',
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
