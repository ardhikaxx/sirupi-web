@extends('layouts.app')

@section('title', 'Detail Tahun Anggaran')

@php
    $menu = 'admin.tahun-anggaran';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tahun-anggaran.index') }}">Tahun Anggaran</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Tahun Anggaran</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.tahun-anggaran.edit', $tahunAnggaran->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.tahun-anggaran.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Tahun</th>
                <td>{{ $tahunAnggaran->tahun }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $tahunAnggaran->nama }}</td>
            </tr>
            <tr>
                <th>Tanggal Mulai</th>
                <td>{{ formatTanggal($tahunAnggaran->tanggal_mulai) }}</td>
            </tr>
            <tr>
                <th>Tanggal Selesai</th>
                <td>{{ formatTanggal($tahunAnggaran->tanggal_selesai) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($tahunAnggaran->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
