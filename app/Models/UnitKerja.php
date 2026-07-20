<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'telepon',
        'email',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class);
    }

    public function pejabats()
    {
        return $this->hasMany(Pejabat::class);
    }
}
