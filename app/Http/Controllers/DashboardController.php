<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        $routes = [
            'super_admin' => 'admin.dashboard',
            'admin' => 'admin.dashboard',
            'operator' => 'operator.dashboard',
            'verifikator' => 'verifikator.dashboard',
            'pimpinan' => 'pimpinan.dashboard',
            'auditor' => 'auditor.dashboard',
        ];

        return redirect()->route($routes[$role] ?? 'login');
    }
}
