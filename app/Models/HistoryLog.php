<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'lampiran', // Tambahkan kolom lampiran jika diperlukan
        'attachments', // Pastikan kolom ini ada
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
     * Metode untuk mencatat log perubahan data pegawai
     */
    public static function recordLog($pegawai, $oldData, $newData, $userId)
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
        ]);
    }

    /**
     * Metode untuk validasi log oleh admin
     * @param int $logId - ID dari HistoryLog yang akan divalidasi
     * @param string $status - Status validasi ('approved' atau 'rejected')
     * @param int $adminId - ID admin yang melakukan validasi
     * @return bool
     */
    public static function validateLog($logId, $status, $adminId)
    {
        $log = self::find($logId);
        if (!$log || !in_array($status, ['approved', 'rejected'])) {
            return false;
        }

        return $log->update([
            'validation_status' => $status,
            'validated_by' => $adminId,
            'validated_at' => now(),
        ]);
    }
}