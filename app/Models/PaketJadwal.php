<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketJadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_pengadaan_id',
        'tahapan',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
    ];

    public function paketPengadaan()
    {
        return $this->belongsTo(PaketPengadaan::class);
    }
}
