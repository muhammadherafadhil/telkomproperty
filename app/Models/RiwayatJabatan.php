<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;
use App\Models\DataPegawai;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_jabatans'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'nik',
        'nama_jabatan',
        'lokasi_penempatan',
        'tanggal_menjabat',
        'tanggal_akhir_jabatan',
        'lamp_jabatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    protected static function booted()
    {
        static::created(function ($riwayatJabatan) {
            $riwayatJabatan->logHistory('create');
        });

        static::updated(function ($riwayatJabatan) {
            $riwayatJabatan->logHistory('update');
        });

        static::deleted(function ($riwayatJabatan) {
            $riwayatJabatan->logHistory('delete');
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

    public static function saveRiwayatJabatan($request)
    {
        try {
            $lamp_jabatan = null;

            if ($request->hasFile('lamp_jabatan')) {
                $lamp_jabatan = $request->file('lamp_jabatan')->store('riwayat_jabatan', 'public');
            }

            return self::create([
                'nik' => Auth::user()->nik,
                'nama_jabatan' => $request->nama_jabatan,
                'lokasi_penempatan' => $request->lokasi_penempatan,
                'tanggal_menjabat' => $request->tanggal_menjabat,
                'tanggal_akhir_jabatan' => $request->tanggal_akhir_jabatan,
                'lamp_jabatan' => $lamp_jabatan,
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }
}
