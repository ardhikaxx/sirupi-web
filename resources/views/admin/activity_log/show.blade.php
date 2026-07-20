@extends('layouts.app')

@section('title', 'Detail Activity Log')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.activity-log') }}">Activity Log</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Detail Activity Log</h5>
        <a href="{{ route('admin.activity-log') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:180px">User</th>
                <td>{{ $activity->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td>{!! statusBadge($activity->tipe) !!}</td>
            </tr>
            <tr>
                <th>Model</th>
                <td>{{ $activity->model }}</td>
            </tr>
            <tr>
                <th>Model ID</th>
                <td>{{ $activity->model_id }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $activity->deskripsi }}</td>
            </tr>
            <tr>
                <th>Data Lama</th>
                <td>
                    @if($activity->data_lama)
                        <pre class="mb-0 font-mono" style="font-size:0.8rem;max-height:200px;overflow:auto;">{{ json_encode(json_decode($activity->data_lama), JSON_PRETTY_PRINT) }}</pre>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Data Baru</th>
                <td>
                    @if($activity->data_baru)
                        <pre class="mb-0 font-mono" style="font-size:0.8rem;max-height:200px;overflow:auto;">{{ json_encode(json_decode($activity->data_baru), JSON_PRETTY_PRINT) }}</pre>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>IP Address</th>
                <td><code>{{ $activity->ip_address ?? '-' }}</code></td>
            </tr>
            <tr>
                <th>User Agent</th>
                <td><small class="text-muted">{{ $activity->user_agent ?? '-' }}</small></td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ formatTanggal($activity->created_at) }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
