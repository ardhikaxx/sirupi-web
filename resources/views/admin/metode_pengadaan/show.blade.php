@extends('layouts.app')

@section('title', 'Detail Metode Pengadaan')

@php
    $menu = 'admin.metode-pengadaan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.metode-pengadaan.index') }}">Metode Pengadaan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Metode Pengadaan</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.metode-pengadaan.edit', $metodePengadaan->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.metode-pengadaan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Kode</th>
                <td>{{ $metodePengadaan->kode }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $metodePengadaan->nama }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $metodePengadaan->keterangan ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
