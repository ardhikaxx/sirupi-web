<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%");
            });
        }

        $activities = $query->latest()->paginate(20);

        $tipeList = ActivityLog::select('tipe')->distinct()->pluck('tipe');
        $users = User::orderBy('name')->get();

        return view('admin.activity-log.index', compact('activities', 'tipeList', 'users'));
    }

    public function show($id)
    {
        $activity = ActivityLog::with('user')->findOrFail($id);
        return view('admin.activity-log.show', compact('activity'));
    }

    public function data(Request $request)
    {
        $columns = ['created_at', 'user_name', 'tipe', 'model', 'deskripsi', 'ip_address'];

        $totalRecords = ActivityLog::count();

        $query = ActivityLog::with('user')->select('activity_logs.*');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $recordsFiltered = $query->count();

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        if ($orderColumn === 'user_name') {
            $query->orderBy(User::select('name')->whereColumn('users.id', 'activity_logs.user_id'), $orderDir);
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $logs = $query->skip($start)->take($length)->get();

        $data = [];
        $colors = ['create' => 'success', 'update' => 'primary', 'delete' => 'danger', 'login' => 'info', 'logout' => 'secondary', 'verifikasi' => 'warning', 'persetujuan' => 'dark', 'publikasi' => 'dark'];

        foreach ($logs as $log) {
            $color = $colors[$log->tipe] ?? 'secondary';
            $data[] = [
                'created_at' => $log->created_at->format('d-m-Y H:i:s'),
                'user_name' => $log->user ? $log->user->name : '-',
                'tipe' => '<span class="badge bg-' . $color . '">' . e($log->tipe) . '</span>',
                'model' => e($log->model),
                'deskripsi' => e($log->deskripsi),
                'ip_address' => e($log->ip_address),
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
