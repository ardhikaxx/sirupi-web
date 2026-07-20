<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubKegiatan;

class SubKegiatanController extends Controller
{
    public function byKegiatan($kegiatanId)
    {
        return SubKegiatan::where('kegiatan_id', $kegiatanId)
            ->orderBy('kode')
            ->get(['id', 'kode', 'nama']);
    }
}
