@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@php
    $menu = 'admin.kegiatan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.kegiatan.index') }}">Kegiatan</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Kegiatan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kegiatan.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" required>
                    @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Program <span class="text-danger">*</span></label>
                    <select name="program_id" class="form-control select2 @error('program_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Program --</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->kode }} - {{ $program->nama }}</option>
                        @endforeach
                    </select>
                    @error('program_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">Batal</a>
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
