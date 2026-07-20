<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketLokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_pengadaan_id',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan_desa',
        'detail_alamat',
    ];

    public function paketPengadaan()
    {
        return $this->belongsTo(PaketPengadaan::class);
    }
}
