@extends('layouts.app')

@section('title', 'Detail Kegiatan')

@php
    $menu = 'admin.kegiatan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.kegiatan.index') }}">Kegiatan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Kegiatan</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Kode</th>
                <td>{{ $kegiatan->kode }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $kegiatan->nama }}</td>
            </tr>
            <tr>
                <th>Program</th>
                <td>{{ $kegiatan->program->kode ?? '-' }} - {{ $kegiatan->program->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Pagu Anggaran</th>
                <td>{{ formatRupiah($kegiatan->pagu_anggaran) }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
