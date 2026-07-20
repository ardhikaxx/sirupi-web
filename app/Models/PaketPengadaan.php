<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketPengadaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_paket',
        'nama_paket',
        'uraian_pekerjaan',
        'pagu_anggaran',
        'hps',
        'status',
        'unit_kerja_id',
        'tahun_anggaran_id',
        'program_id',
        'kegiatan_id',
        'sub_kegiatan_id',
        'sumber_dana_id',
        'jenis_pengadaan_id',
        'metode_pengadaan_id',
        'kategori_id',
        'satuan_id',
        'penyedia_id',
        'pptk_id',
        'pp_id',
        'pa_kpa_id',
        'user_id',
        'parent_paket_id',
        'versi',
        'is_revised',
        'catatan_revisi',
        'is_published',
        'published_at',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }

    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class);
    }

    public function jenisPengadaan()
    {
        return $this->belongsTo(JenisPengadaan::class);
    }

    public function metodePengadaan()
    {
        return $this->belongsTo(MetodePengadaan::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function penyedia()
    {
        return $this->belongsTo(Penyedia::class);
    }

    public function pptk()
    {
        return $this->belongsTo(Pejabat::class, 'pptk_id');
    }

    public function pp()
    {
        return $this->belongsTo(Pejabat::class, 'pp_id');
    }

    public function paKpa()
    {
        return $this->belongsTo(Pejabat::class, 'pa_kpa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentPaket()
    {
        return $this->belongsTo(PaketPengadaan::class, 'parent_paket_id');
    }

    public function childPakets()
    {
        return $this->hasMany(PaketPengadaan::class, 'parent_paket_id');
    }

    public function paketAnggarans()
    {
        return $this->hasMany(PaketAnggaran::class);
    }

    public function paketJadwals()
    {
        return $this->hasMany(PaketJadwal::class);
    }

    public function paketLokasis()
    {
        return $this->hasMany(PaketLokasi::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function riwayatPersetujuans()
    {
        return $this->hasMany(RiwayatPersetujuan::class);
    }
}
