<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
    
    public static function catat($user, $tipe, $model = null, $modelId = null, $deskripsi = null, $dataLama = null, $dataBaru = null)
    {
        ActivityLog::create([
            'user_id' => $user?->id,
            'tipe' => $tipe,
            'model' => $model,
            'model_id' => $modelId,
            'deskripsi' => $deskripsi,
            'data_lama' => $dataLama ? json_encode($dataLama) : null,
            'data_baru' => $dataBaru ? json_encode($dataBaru) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
