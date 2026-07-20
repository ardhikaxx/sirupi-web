<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UnitKerja;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $users = User::with('unitKerja')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $unitKerjas = UnitKerja::where('is_active', true)->get();
        return view('admin.user.create', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'nullable|string|max:30|unique:users,nip',
            'jabatan' => 'nullable|string|max:255',
            'role' => 'required|in:super_admin,admin,operator,verifikator,pimpinan,auditor',
            'unit_kerja_id' => 'nullable|exists:unit_kerjas,id',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('password_confirmation');
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        $this->activityLogService->logCreate(
            auth()->user(),
            $user,
            "Membuat user: {$user->name} ({$user->email})"
        );

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::with(['unitKerja', 'paketPengadaans'])->findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $unitKerjas = UnitKerja::where('is_active', true)->get();
        return view('admin.user.edit', compact('user', 'unitKerjas'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'nip' => 'nullable|string|max:30|unique:users,nip,' . $id,
            'jabatan' => 'nullable|string|max:255',
            'role' => 'required|in:super_admin,admin,operator,verifikator,pimpinan,auditor',
            'unit_kerja_id' => 'nullable|exists:unit_kerjas,id',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $dataLama = $user->toArray();
        $user->update($request->all());

        $this->activityLogService->logUpdate(
            auth()->user(),
            $user,
            $dataLama,
            $user->toArray(),
            "Memperbarui user: {$user->name} ({$user->email})"
        );

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->paketPengadaans()->count() > 0) {
            return redirect()->route('admin.user.index')
                ->with('error', 'User tidak dapat dihapus karena masih memiliki paket pengadaan.');
        }

        $this->activityLogService->logDelete(
            auth()->user(),
            $user,
            "Menghapus user: {$user->name} ({$user->email})"
        );

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($request->password)]);

        $this->activityLogService->log(
            auth()->user(),
            'update',
            get_class($user),
            $user->id,
            "Reset password user: {$user->name} ({$user->email})"
        );

        return redirect()->route('admin.user.index')
            ->with('success', 'Password user berhasil direset.');
    }
}
