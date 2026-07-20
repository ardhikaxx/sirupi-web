<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class ActivityLogService
{
    public function log(
        User $user,
        string $tipe,
        ?string $model = null,
        ?int $modelId = null,
        ?string $deskripsi = null,
        ?array $dataLama = null,
        ?array $dataBaru = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => $user->id,
            'tipe' => $tipe,
            'model' => $model,
            'model_id' => $modelId,
            'deskripsi' => $deskripsi,
            'data_lama' => $dataLama ? json_encode($dataLama) : null,
            'data_baru' => $dataBaru ? json_encode($dataBaru) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function logCreate(User $user, Model $record, ?string $deskripsi = null): ActivityLog
    {
        return $this->log(
            $user,
            'create',
            get_class($record),
            $record->getKey(),
            $deskripsi ?? $this->buildDeskripsi('membuat', $record),
            null,
            $record->toArray()
        );
    }

    public function logUpdate(User $user, Model $record, array $dataLama, array $dataBaru, ?string $deskripsi = null): ActivityLog
    {
        return $this->log(
            $user,
            'update',
            get_class($record),
            $record->getKey(),
            $deskripsi ?? $this->buildDeskripsi('memperbarui', $record),
            $dataLama,
            $dataBaru
        );
    }

    public function logDelete(User $user, Model $record, ?string $deskripsi = null): ActivityLog
    {
        return $this->log(
            $user,
            'delete',
            get_class($record),
            $record->getKey(),
            $deskripsi ?? $this->buildDeskripsi('menghapus', $record),
            $record->toArray(),
            null
        );
    }

    public function logRestore(User $user, Model $record, ?string $deskripsi = null): ActivityLog
    {
        return $this->log(
            $user,
            'restore',
            get_class($record),
            $record->getKey(),
            $deskripsi ?? $this->buildDeskripsi('memulihkan', $record),
            null,
            null
        );
    }

    public function logLogin(User $user): ActivityLog
    {
        return $this->log($user, 'login', null, null, 'Pengguna login ke sistem');
    }

    public function logLogout(User $user): ActivityLog
    {
        return $this->log($user, 'logout', null, null, 'Pengguna logout dari sistem');
    }

    private function buildDeskripsi(string $tindakan, Model $record): string
    {
        $nama = method_exists($record, 'getActivityLogName')
            ? $record->getActivityLogName()
            : ($record->getAttribute('nama') ?? $record->getAttribute('name') ?? '#' . $record->getKey());

        $kelas = class_basename($record);

        return "{$tindakan} {$kelas}: {$nama}";
    }
}
