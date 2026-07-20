@extends('layouts.app')

@section('title', 'Activity Log')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Activity Log</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Activity Log</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
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
                <button id="resetFilter" class="btn btn-secondary w-100"><i class="fas fa-sync me-1"></i>Reset Filter</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="activityLogTable">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Tipe</th>
                        <th>Model</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                    <tr>
                        <td>{{ formatTanggal($activity->created_at, 'd-m-Y H:i:s') }}</td>
                        <td>{{ $activity->user->name ?? '-' }}</td>
                        <td>
                            @php
                                $tipeColors = ['create' => 'success', 'update' => 'primary', 'delete' => 'danger', 'login' => 'info', 'logout' => 'secondary', 'verifikasi' => 'warning', 'persetujuan' => 'dark', 'publikasi' => 'dark'];
                            @endphp
                            <span class="badge bg-{{ $tipeColors[$activity->tipe] ?? 'secondary' }}">{{ $activity->tipe }}</span>
                        </td>
                        <td>{{ $activity->model }}</td>
                        <td>{{ $activity->deskripsi }}</td>
                        <td class="font-mono">{{ $activity->ip_address ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox me-2"></i>Belum ada data aktivitas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#activityLogTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.11/i18n/id.json' },
            order: [[0, 'desc']]
        });

        $('#filterUser').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        $('#filterTipe').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        $('#filterDate').flatpickr({
            onChange: function(selectedDates, dateStr) {
                table.column(0).search(dateStr).draw();
            }
        });

        $('#resetFilter').on('click', function() {
            $('#filterUser, #filterTipe').val('');
            $('#filterDate').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>
@endpush
