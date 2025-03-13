<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;
use App\Models\DataPegawai;

class Hobi extends Model
{
    use HasFactory;

    protected $table = 'hobis'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'nik',
        'hobi',
        'lamp_kegiatan_hobi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    protected static function booted()
    {
        static::created(function ($hobi) {
            $hobi->logHistory('create');
        });

        static::updated(function ($hobi) {
            $hobi->logHistory('update');
        });

        static::deleted(function ($hobi) {
            $hobi->logHistory('delete');
        });
    }

    public function logHistory($action)
    {
        $dataPegawai = DataPegawai::where('nik', $this->nik)->first();
        
        if (!$dataPegawai) {
            return; // Jika Data Pegawai tidak ditemukan, hentikan proses
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

    public static function saveHobi($request)
    {
        try {
            $lamp_kegiatan_hobi = null;

            if ($request->hasFile('lamp_kegiatan_hobi')) {
                $lamp_kegiatan_hobi = $request->file('lamp_kegiatan_hobi')->store('hobi', 'public');
            }

            return self::create([
                'nik' => Auth::user()->nik,
                'hobi' => $request->hobi,
                'lamp_kegiatan_hobi' => $lamp_kegiatan_hobi,
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }
}
