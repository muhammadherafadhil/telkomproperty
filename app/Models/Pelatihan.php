<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;
use App\Models\DataPegawai;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihans'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'nik',
        'pelatihan',
        'tanggal_pelatihan',
        'tanggal_selesai_pelatihan',
        'nama_penyelenggara',
        'lamp_pelatihan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    protected static function booted()
    {
        static::created(function ($pelatihan) {
            $pelatihan->logHistory('create');
        });

        static::updated(function ($pelatihan) {
            $pelatihan->logHistory('update');
        });

        static::deleted(function ($pelatihan) {
            $pelatihan->logHistory('delete');
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

    public static function savePelatihan($request)
    {
        try {
            $lamp_pelatihan = null;

            if ($request->hasFile('lamp_pelatihan')) {
                $lamp_pelatihan = $request->file('lamp_pelatihan')->store('pelatihan', 'public');
            }

            return self::create([
                'nik' => Auth::user()->nik,
                'pelatihan' => $request->pelatihan,
                'tanggal_pelatihan' => $request->tanggal_pelatihan,
                'tanggal_selesai_pelatihan' => $request->tanggal_selesai_pelatihan,
                'nama_penyelenggara' => $request->nama_penyelenggara,
                'lamp_pelatihan' => $lamp_pelatihan,
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }
}
