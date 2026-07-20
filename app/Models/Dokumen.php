<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'paket_pengadaan_id',
        'nama_dokumen',
        'tipe_dokumen',
        'file_path',
        'file_size',
        'mime_type',
        'is_public',
        'uploaded_by',
    ];

    public function paketPengadaan()
    {
        return $this->belongsTo(PaketPengadaan::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
