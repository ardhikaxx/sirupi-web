<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPersetujuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_pengadaan_id',
        'user_id',
        'aksi',
        'status_dari',
        'status_ke',
        'catatan',
    ];

    public function paketPengadaan()
    {
        return $this->belongsTo(PaketPengadaan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
