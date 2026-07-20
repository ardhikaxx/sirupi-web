@extends('layouts.app')

@section('title', 'Tambah Program')

@php
    $menu = 'admin.program';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.program.index') }}">Program</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Program</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.program.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" required>
                    @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Anggaran <span class="text-danger">*</span></label>
                    <select name="tahun_anggaran_id" class="form-control @error('tahun_anggaran_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Tahun Anggaran --</option>
                        @foreach($tahunAnggarans as $ta)
                            <option value="{{ $ta->id }}" {{ old('tahun_anggaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->nama }} ({{ $ta->tahun }})</option>
                        @endforeach
                    </select>
                    @error('tahun_anggaran_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <textarea name="nama" class="form-control @error('nama') is-invalid @enderror" rows="3" required>{{ old('nama') }}</textarea>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pagu Anggaran <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="pagu_anggaran" class="form-control @error('pagu_anggaran') is-invalid @enderror" value="{{ old('pagu_anggaran') }}" required>
                    </div>
                    @error('pagu_anggaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.program.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
