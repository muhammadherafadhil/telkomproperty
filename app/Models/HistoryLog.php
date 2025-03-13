<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HistoryLog extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment)
     */
    protected $fillable = [
        'data_pegawai_id',
        'action',
        'old_data',
        'new_data',
        'user_id',
        'name',
        'validation_status',
        'validated_by',
        'validated_at',
        'lampiran', // Menyimpan lampiran (file)
        'hobi_id', // Menyimpan ID hobi
        'keterampilan_id', // Menyimpan ID keterampilan
        'pelatihan_id', // Menyimpan ID pelatihan
        'pendidikan_id', // Menyimpan ID pendidikan
        'penghargaan_id', // Menyimpan ID penghargaan
        'jabatan_id', // Menyimpan ID jabatan
    ];

    /**
     * Konversi data JSON ke array secara otomatis
     */
    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    /**
     * Relasi dengan model DataPegawai
     * Setiap HistoryLog berhubungan dengan satu DataPegawai
     */
    public function dataPegawai()
    {
        return $this->belongsTo(DataPegawai::class, 'data_pegawai_id');
    }

    /**
     * Relasi dengan model User (Pembuat Log)
     * Setiap HistoryLog berhubungan dengan satu User (pengguna yang membuat atau mengubah data)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi dengan model User (Validator)
     * Setiap HistoryLog divalidasi oleh satu admin (jika sudah divalidasi)
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Relasi dengan model Comment
     * Setiap HistoryLog dapat memiliki banyak komentar
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'log_id'); // Gunakan 'log_id' bukan 'history_log_id'
    }

    /**
     * Relasi dengan model Like
     * Setiap HistoryLog dapat memiliki banyak like
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'log_id'); // Gunakan 'log_id' bukan 'history_log_id'
    }

    /**
     * Relasi dengan model Hobi
     * Setiap HistoryLog berhubungan dengan satu Hobi
     */
    public function hobi()
    {
        return $this->belongsTo(Hobi::class, 'hobi_id');
    }

    /**
     * Relasi dengan model Pelatihan
     * Setiap HistoryLog berhubungan dengan satu Pelatihan
     */
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id', 'id'); // 'pelatihan_id' adalah foreign key dalam tabel history_logs
    }

    /**
     * Relasi dengan model Penghargaan
     * Setiap HistoryLog berhubungan dengan satu Penghargaan
     */
    public function penghargaan()
    {
        return $this->belongsTo(Penghargaan::class, 'penghargaan_id');
    }

    /**
     * Metode untuk mencatat log perubahan data pegawai
     */
    public static function recordLog($pegawai, $oldData, $newData, $userId, $hobiId = null, $keterampilanId = null, $pelatihanId = null, $pendidikanId = null, $penghargaanId = null, $jabatanId = null)
    {
        $changes = [];
        foreach ($oldData as $key => $value) {
            if (isset($newData[$key]) && $value != $newData[$key]) {
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . " dari " . $value . " menjadi " . $newData[$key];
            }
        }
        $logDescription = $pegawai->nama_lengkap . ' telah melakukan perubahan: ';
        $logDescription .= !empty($changes) ? implode(', ', $changes) : 'Tidak ada perubahan signifikan yang tercatat.';

        return self::create([
            'data_pegawai_id' => $pegawai->id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'user_id' => $userId,
            'name' => $logDescription,
            'validation_status' => 'pending',
            'validated_by' => null,
            'validated_at' => null,
            'lampiran' => $pegawai->photo, // Menyimpan foto pegawai sebagai lampiran
            'hobi_id' => $hobiId, // Menyimpan ID hobi jika ada
            'keterampilan_id' => $keterampilanId, // Menyimpan ID keterampilan jika ada
            'pelatihan_id' => $pelatihanId, // Menyimpan ID pelatihan jika ada
            'pendidikan_id' => $pendidikanId, // Menyimpan ID pendidikan jika ada
            'penghargaan_id' => $penghargaanId, // Menyimpan ID penghargaan jika ada
            'jabatan_id' => $jabatanId, // Menyimpan ID jabatan jika ada
        ]);
    }

    /**
     * Metode untuk mencatat perubahan data dalam HistoryLog
     */
    public function storeLog($dataPegawaiId, $action, $oldData, $newData, $request, $hobiId = null, $keterampilanId = null, $pelatihanId = null, $pendidikanId = null, $penghargaanId = null, $jabatanId = null)
    {
        $dataPegawai = DataPegawai::find($dataPegawaiId);
        if (!$dataPegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan');
        }

        // Handle foto karyawan atau file lainnya
        $attachedFiles = [];
        $attachmentFields = ['lampiran', 'hobi', 'keterampilan', 'pelatihan', 'pendidikan', 'penghargaan', 'jabatan'];

        foreach ($attachmentFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/lampiran', $fileName); // Menyimpan file di storage

                // Menyimpan URL file untuk ditampilkan
                $attachedFiles[$field] = Storage::url($path);
            }
        }

        // Jika ada lampiran, tambahkan ke data baru
        $newDataWithAttachments = array_merge($newData, $attachedFiles);

        // Cek perubahan pada data
        $changes = [];
        foreach ($oldData as $key => $value) {
            if (isset($newDataWithAttachments[$key]) && $value != $newDataWithAttachments[$key]) {
                $changes[] = "$key berubah dari $value menjadi {$newDataWithAttachments[$key]}";
            }
        }
        $changeDescription = implode(', ', $changes);

        HistoryLog::create([
            'data_pegawai_id' => $dataPegawaiId,
            'action' => $action,
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newDataWithAttachments), // Menyimpan data baru dengan lampiran
            'name' => $changeDescription,
            'user_id' => auth()->user()->id,
            'lampiran' => $attachedFiles['lampiran'] ?? null, // Menyimpan file lampiran utama jika ada
            'hobi_id' => $hobiId, // Menyimpan ID hobi jika ada
            'keterampilan_id' => $keterampilanId, // Menyimpan ID keterampilan jika ada
            'pelatihan_id' => $pelatihanId, // Menyimpan ID pelatihan jika ada
            'pendidikan_id' => $pendidikanId, // Menyimpan ID pendidikan jika ada
            'penghargaan_id' => $penghargaanId, // Menyimpan ID penghargaan jika ada
            'jabatan_id' => $jabatanId, // Menyimpan ID jabatan jika ada
        ]);
    }
}
