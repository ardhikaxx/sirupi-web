<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUnitKerja
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && in_array($user->role, ['operator']) && !$user->unit_kerja_id) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda belum memiliki unit kerja. Hubungi Administrator.');
        }
        return $next($request);
    }
}
