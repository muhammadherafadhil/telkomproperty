<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;
use App\Models\DataPegawai;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikans'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'nik',
        'jenjang_pendidikan',
        'institusi',
        'jurusan',
        'tahun_lulus',
        'lamp_ijazah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    protected static function booted()
    {
        static::created(function ($pendidikan) {
            $pendidikan->logHistory('create');
        });

        static::updated(function ($pendidikan) {
            $pendidikan->logHistory('update');
        });

        static::deleted(function ($pendidikan) {
            $pendidikan->logHistory('delete');
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

    public static function savePendidikan($request)
    {
        try {
            $lamp_ijazah = null;

            if ($request->hasFile('lamp_ijazah')) {
                $lamp_ijazah = $request->file('lamp_ijazah')->store('ijazah', 'public');
            }

            return self::create([
                'nik' => Auth::user()->nik,
                'jenjang_pendidikan' => $request->jenjang_pendidikan,
                'institusi' => $request->institusi,
                'jurusan' => $request->jurusan,
                'tahun_lulus' => $request->tahun_lulus,
                'lamp_ijazah' => $lamp_ijazah,
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }
}