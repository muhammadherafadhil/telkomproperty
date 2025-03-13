<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Keterampilan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'keterampilan',
        'lamp_keterampilan',
    ];

    protected static function booted()
    {
        static::created(function ($keterampilan) {
            $keterampilan->logHistory('create');
        });

        static::updated(function ($keterampilan) {
            $keterampilan->logHistory('update');
        });

        static::deleted(function ($keterampilan) {
            $keterampilan->logHistory('delete');
        });
    }

    public function historyLogs()
    {
        return $this->hasMany(HistoryLog::class, 'keterampilan_id');
    }

    public function dataPegawai()
    {
        return $this->belongsTo(DataPegawai::class, 'nik', 'nik');
    }

    public function logHistory($action)
    {
        $changes = $this->getChanges();

        if ($action === 'update' && empty($changes)) {
            return;
        }

        $dataPegawai = DataPegawai::where('nik', $this->nik)->first();
        if (!$dataPegawai) {
            return;
        }

        $historyLog = new HistoryLog();
        $historyLog->data_pegawai_id = $dataPegawai->id;
        $historyLog->keterampilan_id = $this->id;
        $historyLog->action = $action;

        if ($action === 'update') {
            $historyLog->old_data = json_encode($this->getOriginal(), JSON_UNESCAPED_UNICODE);
            $historyLog->new_data = json_encode($changes, JSON_UNESCAPED_UNICODE);
        } elseif ($action === 'create') {
            $historyLog->new_data = json_encode($this->attributesToArray(), JSON_UNESCAPED_UNICODE);
        } elseif ($action === 'delete') {
            $historyLog->old_data = json_encode($this->getOriginal(), JSON_UNESCAPED_UNICODE);
        }

        $historyLog->name = $this->generateChangeDescription($this->getOriginal(), $changes);
        $historyLog->save();
    }

    protected function generateChangeDescription($oldData, $newData)
    {
        $description = [];

        foreach ($newData as $key => $value) {
            $oldValue = $oldData[$key] ?? '(kosong)';
            $description[] = ucfirst(str_replace('_', ' ', $key)) . ' berubah dari ' . $oldValue . ' menjadi ' . $value;
        }

        return implode(', ', $description) ?: 'Data baru ditambahkan';
    }
}
