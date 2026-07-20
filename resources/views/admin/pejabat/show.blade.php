@extends('layouts.app')

@section('title', 'Detail Pejabat')

@php
    $menu = 'admin.pejabat';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.pejabat.index') }}">Pejabat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Pejabat</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pejabat.edit', $pejabat->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.pejabat.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Nama</th>
                <td>{{ $pejabat->nama }}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>{{ $pejabat->nip ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $pejabat->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td>
                    @php $tipeColors = ['PPTK' => 'info', 'PP' => 'primary', 'PA_KPA' => 'success']; @endphp
                    <span class="badge bg-{{ $tipeColors[$pejabat->tipe] ?? 'secondary' }}">{{ $pejabat->tipe }}</span>
                </td>
            </tr>
            <tr>
                <th>Unit Kerja</th>
                <td>{{ $pejabat->unitKerja->nama ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
