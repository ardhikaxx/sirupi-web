<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.',
            ])->withInput($request->only('email'));
        }

        Auth::login($user, $request->boolean('remember'));

        $this->activityLogService->logLogin($user);

        return redirect()->route($this->redirectTo());
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->activityLogService->logLogout($user);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function redirectTo()
    {
        $role = Auth::user()->role;

        $routes = [
            'super_admin' => 'admin.dashboard',
            'admin' => 'admin.dashboard',
            'operator' => 'operator.dashboard',
            'verifikator' => 'verifikator.dashboard',
            'pimpinan' => 'pimpinan.dashboard',
            'auditor' => 'auditor.dashboard',
        ];

        return $routes[$role] ?? 'login';
    }
}
