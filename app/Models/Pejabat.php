<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'tipe',
        'unit_kerja_id',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function paketPengadaansAsPptk()
    {
        return $this->hasMany(PaketPengadaan::class, 'pptk_id');
    }

    public function paketPengadaansAsPp()
    {
        return $this->hasMany(PaketPengadaan::class, 'pp_id');
    }

    public function paketPengadaansAsPaKpa()
    {
        return $this->hasMany(PaketPengadaan::class, 'pa_kpa_id');
    }
}
