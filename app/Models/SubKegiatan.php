<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'kegiatan_id',
        'pagu_anggaran',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }
}
