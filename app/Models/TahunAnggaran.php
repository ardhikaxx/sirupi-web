<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAnggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }
}
