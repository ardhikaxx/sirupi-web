@extends('layouts.app')

@section('title', 'Tambah Pejabat')

@php
    $menu = 'admin.pejabat';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.pejabat.index') }}">Pejabat</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Pejabat</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pejabat.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                    @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}">
                    @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" class="form-control @error('tipe') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="PPTK" {{ old('tipe') == 'PPTK' ? 'selected' : '' }}>PPTK</option>
                        <option value="PP" {{ old('tipe') == 'PP' ? 'selected' : '' }}>PP</option>
                        <option value="PA_KPA" {{ old('tipe') == 'PA_KPA' ? 'selected' : '' }}>PA/KPA</option>
                    </select>
                    @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Unit Kerja</label>
                    <select name="unit_kerja_id" class="form-control @error('unit_kerja_id') is-invalid @enderror">
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach($unitKerjas as $uk)
                            <option value="{{ $uk->id }}" {{ old('unit_kerja_id') == $uk->id ? 'selected' : '' }}>{{ $uk->kode }} - {{ $uk->nama }}</option>
                        @endforeach
                    </select>
                    @error('unit_kerja_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.pejabat.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
