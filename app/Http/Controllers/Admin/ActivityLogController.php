<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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

        return view('admin.activity-log.index', compact('activities', 'tipeList'));
    }

    public function show($id)
    {
        $activity = ActivityLog::with('user')->findOrFail($id);
        return view('admin.activity-log.show', compact('activity'));
    }
}
