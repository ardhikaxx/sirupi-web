@extends('layouts.app')

@section('title', 'Activity Log')

@php
    $menu = 'activity-log';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Activity Log</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Activity Log</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="filterUser" class="form-control">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterTipe" class="form-control">
                    <option value="">Semua Tipe</option>
                    <option value="create">Create</option>
                    <option value="update">Update</option>
                    <option value="delete">Delete</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                    <option value="verifikasi">Verifikasi</option>
                    <option value="persetujuan">Persetujuan</option>
                    <option value="publikasi">Publikasi</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" id="filterDate" class="form-control" placeholder="Filter Tanggal">
            </div>
            <div class="col-md-3">
                <button id="resetFilterLog" class="btn btn-secondary w-100"><i class="fas fa-sync me-1"></i>Reset Filter</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="activityLogTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Tipe</th>
                        <th>Model</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#activityLogTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.activity-log.data') }}',
                data: function(d) {
                    d.user_id = $('#filterUser').val();
                    d.tipe = $('#filterTipe').val();
                    d.date = $('#filterDate').val();
                }
            },
            columns: [
                { data: 'created_at', name: 'created_at', render: function(data) { return moment(data).format('D MMMM YYYY HH:mm'); } },
                { data: 'user_name', name: 'user.name' },
                { data: 'tipe', name: 'tipe', render: function(data) {
                    var colors = { create: 'success', update: 'primary', delete: 'danger', login: 'info', logout: 'secondary', verifikasi: 'warning', persetujuan: 'dark', publikasi: 'dark' };
                    return '<span class="badge bg-' + (colors[data] || 'secondary') + '">' + data + '</span>';
                }},
                { data: 'model', name: 'model' },
                { data: 'deskripsi', name: 'deskripsi' },
                { data: 'ip_address', name: 'ip_address' }
            ],
            order: [[0, 'desc']],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' }
        });

        $('#filterUser, #filterTipe').on('change', function() {
            table.draw();
        });

        $('#filterDate').flatpickr({
            onChange: function() { table.draw(); }
        });

        $('#resetFilterLog').on('click', function() {
            $('#filterUser, #filterTipe').val('');
            $('#filterDate').val('');
            table.draw();
        });
    });
</script>
@endpush
