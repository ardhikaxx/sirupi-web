@extends('layouts.app')

@section('title', 'Detail Unit Kerja')

@php
    $menu = 'admin.unit-kerja';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.unit-kerja.index') }}">Unit Kerja</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Unit Kerja</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.unit-kerja.edit', $unitKerja->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.unit-kerja.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Kode</th>
                <td>{{ $unitKerja->kode }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $unitKerja->nama }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $unitKerja->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $unitKerja->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $unitKerja->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($unitKerja->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Nonaktif</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
