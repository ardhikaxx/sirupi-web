<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    public function byProgram($programId)
    {
        return Kegiatan::where('program_id', $programId)
            ->orderBy('kode')
            ->get(['id', 'kode', 'nama']);
    }
}
