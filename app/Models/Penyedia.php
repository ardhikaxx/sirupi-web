<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'npwp',
        'alamat',
        'telepon',
        'email',
        'jenis',
    ];

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }
}
