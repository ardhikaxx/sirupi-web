<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
    ];

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }

    public function paketAnggarans()
    {
        return $this->hasMany(PaketAnggaran::class);
    }
}
