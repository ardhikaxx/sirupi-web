@extends('layouts.app')

@section('title', 'Detail User')

@php
    $menu = 'admin.user';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail User</h5>
        <div class="d-flex gap-2">
            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                <i class="fas fa-key me-1"></i>Reset Password
            </button>
            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>{{ $user->nip ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $user->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Role</th>
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
            </tr>
            <tr>
                <th>Unit Kerja</th>
                <td>{{ $user->unitKerja->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $user->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($user->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Nonaktif</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.user.reset-password', $user->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
