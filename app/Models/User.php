<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'jabatan',
        'role',
        'unit_kerja_id',
        'telepon',
        'foto',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function paketPengadaans()
    {
        return $this->hasMany(PaketPengadaan::class, 'user_id');
    }

    public function riwayatPersetujuans()
    {
        return $this->hasMany(RiwayatPersetujuan::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'uploaded_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function isVerifikator(): bool
    {
        return $this->role === 'verifikator';
    }

    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    public function isAuditor(): bool
    {
        return $this->role === 'auditor';
    }
}
