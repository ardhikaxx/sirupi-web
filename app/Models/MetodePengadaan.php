<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePengadaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }
}
