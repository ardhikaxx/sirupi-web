<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'tahun_anggaran_id',
        'pagu_anggaran',
    ];

    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class);
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }
}
