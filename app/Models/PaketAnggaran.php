<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketAnggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_pengadaan_id',
        'nama_item',
        'volume',
        'satuan_id',
        'harga_satuan',
        'total',
    ];

    public function paketPengadaan()
    {
        return $this->belongsTo(PaketPengadaan::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
