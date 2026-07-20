@extends('layouts.app')

@section('title', 'Detail Sub Kegiatan')

@php
    $menu = 'admin.sub-kegiatan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sub-kegiatan.index') }}">Sub Kegiatan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Sub Kegiatan</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.sub-kegiatan.edit', $subKegiatan->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.sub-kegiatan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Kode</th>
                <td>{{ $subKegiatan->kode }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $subKegiatan->nama }}</td>
            </tr>
            <tr>
                <th>Kegiatan</th>
                <td>{{ $subKegiatan->kegiatan->kode ?? '-' }} - {{ $subKegiatan->kegiatan->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Pagu Anggaran</th>
                <td>{{ formatRupiah($subKegiatan->pagu_anggaran) }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
