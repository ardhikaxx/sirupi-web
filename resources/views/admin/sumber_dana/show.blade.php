@extends('layouts.app')

@section('title', 'Detail Sumber Dana')

@php
    $menu = 'admin.sumber-dana';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sumber-dana.index') }}">Sumber Dana</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Sumber Dana</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.sumber-dana.edit', $sumberDana->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.sumber-dana.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Kode</th>
                <td>{{ $sumberDana->kode }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $sumberDana->nama }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
