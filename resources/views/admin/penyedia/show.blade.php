@extends('layouts.app')

@section('title', 'Detail Penyedia')

@php
    $menu = 'admin.penyedia';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.penyedia.index') }}">Penyedia</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Penyedia</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.penyedia.edit', $penyedia->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.penyedia.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Nama</th>
                <td>{{ $penyedia->nama }}</td>
            </tr>
            <tr>
                <th>NPWP</th>
                <td>{{ $penyedia->npwp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $penyedia->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $penyedia->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $penyedia->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis</th>
                <td>{{ $penyedia->jenis ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
