@extends('layouts.app')

@section('title', 'Edit Sub Kegiatan')

@php
    $menu = 'admin.sub-kegiatan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sub-kegiatan.index') }}">Sub Kegiatan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Sub Kegiatan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.sub-kegiatan.update', $subKegiatan->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $subKegiatan->kode) }}" required>
                    @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kegiatan <span class="text-danger">*</span></label>
                    <select name="kegiatan_id" class="form-control select2 @error('kegiatan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id', $subKegiatan->kegiatan_id) == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->kode }} - {{ $kegiatan->nama }}</option>
                        @endforeach
                    </select>
                    @error('kegiatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <textarea name="nama" class="form-control @error('nama') is-invalid @enderror" rows="3" required>{{ old('nama', $subKegiatan->nama) }}</textarea>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pagu Anggaran <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="pagu_anggaran" class="form-control @error('pagu_anggaran') is-invalid @enderror" value="{{ old('pagu_anggaran', $subKegiatan->pagu_anggaran) }}" required>
                    </div>
                    @error('pagu_anggaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ route('admin.sub-kegiatan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.select2').select2({ theme: 'bootstrap-5' });
</script>
@endpush
