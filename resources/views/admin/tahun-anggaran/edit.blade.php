@extends('layouts.app')

@section('title', 'Edit Tahun Anggaran')

@php
    $menu = 'admin.tahun-anggaran';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tahun-anggaran.index') }}">Tahun Anggaran</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Tahun Anggaran</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tahun-anggaran.update', $tahunAnggaran->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                    <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $tahunAnggaran->tahun) }}" required>
                    @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $tahunAnggaran->nama) }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="text" name="tanggal_mulai" class="form-control datepicker @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $tahunAnggaran->tanggal_mulai) }}" required>
                    @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="text" name="tanggal_selesai" class="form-control datepicker @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $tahunAnggaran->tanggal_selesai) }}" required>
                    @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $tahunAnggaran->is_active) ? 'checked' : '' }} id="isActive">
                        <label class="form-check-label" for="isActive">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ route('admin.tahun-anggaran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.datepicker').flatpickr();
</script>
@endpush
