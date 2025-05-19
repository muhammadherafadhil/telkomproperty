<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;
use App\Models\DataPegawai;

class Keterampilan extends Model
{
    use HasFactory;

    protected $table = 'keterampilans'; // Sesuaikan dengan nama tabel jika tidak default

    protected $fillable = [
        'nik',
        'keterampilan',
        'lamp_keterampilan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

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

    public function logHistory($action)
    {
        $dataPegawai = DataPegawai::where('nik', $this->nik)->first();

        if (!$dataPegawai) {
            return; // Jika Data Pegawai tidak ditemukan, hentikan proses log
        }

        $historyLog = new HistoryLog();
        $historyLog->data_pegawai_id = $dataPegawai->id;
        $historyLog->action = $action;

        if ($action === 'update') {
            $historyLog->old_data = json_encode($this->getOriginal(), JSON_UNESCAPED_UNICODE);
            $historyLog->new_data = json_encode($this->getChanges(), JSON_UNESCAPED_UNICODE);
        } elseif ($action === 'create') {
            $historyLog->new_data = json_encode($this->attributesToArray(), JSON_UNESCAPED_UNICODE);
        } elseif ($action === 'delete') {
            $historyLog->old_data = json_encode($this->getOriginal(), JSON_UNESCAPED_UNICODE);
        }

        $historyLog->name = $this->generateChangeDescription($this->getOriginal(), $this->getChanges());
        $historyLog->save();
    }

    protected function generateChangeDescription($oldData, $newData)
    {
        $description = [];

        foreach ($oldData as $key => $value) {
            if (array_key_exists($key, $newData) && $value != $newData[$key]) {
                $description[] = ucfirst(str_replace('_', ' ', $key)) . ' changed from ' . $value . ' to ' . $newData[$key];
            }
        }

        return implode(', ', $description);
    }

    public static function saveKeterampilan($request)
    {
        try {
            $lamp_keterampilan = null;

            if ($request->hasFile('lamp_keterampilan')) {
                $lamp_keterampilan = $request->file('lamp_keterampilan')->store('keterampilan', 'public');
            }

            return self::create([
                'nik' => Auth::user()->nik,
                'keterampilan' => $request->keterampilan,
                'lamp_keterampilan' => $lamp_keterampilan,
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }
}
