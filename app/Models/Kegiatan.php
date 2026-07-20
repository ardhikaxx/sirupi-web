<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'program_id',
        'pagu_anggaran',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function subKegiatans()
    {
        return $this->hasMany(SubKegiatan::class);
    }

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }
}
