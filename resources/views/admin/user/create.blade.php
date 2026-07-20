@extends('layouts.app')

@section('title', 'Tambah User')

@php
    $menu = 'admin.user';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah User</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                    @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}">
                    @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}">
                    @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror" id="roleSelect" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="verifikator" {{ old('role') == 'verifikator' ? 'selected' : '' }}>Verifikator</option>
                        <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                        <option value="auditor" {{ old('role') == 'auditor' ? 'selected' : '' }}>Auditor</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3" id="unitKerjaWrapper" style="{{ old('role') == 'operator' ? '' : 'display:none' }}">
                    <label class="form-label">Unit Kerja</label>
                    <select name="unit_kerja_id" class="form-control @error('unit_kerja_id') is-invalid @enderror">
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach($unitKerjas as $uk)
                            <option value="{{ $uk->id }}" {{ old('unit_kerja_id') == $uk->id ? 'selected' : '' }}>{{ $uk->kode }} - {{ $uk->nama }}</option>
                        @endforeach
                    </select>
                    @error('unit_kerja_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} id="isActive">
                        <label class="form-check-label" for="isActive">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#roleSelect').on('change', function() {
        if ($(this).val() === 'operator') {
            $('#unitKerjaWrapper').show();
        } else {
            $('#unitKerjaWrapper').hide();
            $('#unitKerjaWrapper select').val('');
        }
    });
</script>
@endpush
