<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    // Nama tabel (optional, jika tidak sesuai dengan konvensi)
    protected $table = 'kelurahans';

    // Relasi dengan Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kec');
    }

    // Event yang dipanggil setelah record diubah (create, update, delete)
    protected static function booted()
    {
        // Setelah data kelurahan dibuat
        static::created(function ($kelurahan) {
            $kelurahan->logHistory('create');
        });

        // Setelah data kelurahan diperbarui
        static::updated(function ($kelurahan) {
            $kelurahan->logHistory('update');
        });

        // Setelah data kelurahan dihapus
        static::deleted(function ($kelurahan) {
            $kelurahan->logHistory('delete');
        });
    }

    // Fungsi untuk menyimpan log history ke tabel history_logs
    public function logHistory($action)
    {
        $changes = $this->getChanges(); // Mengambil data yang berubah

        // Menyimpan log ke tabel history_logs
        $historyLog = new HistoryLog();
        $historyLog->data_pegawai_id = $this->id; // ID kelurahan yang berubah
        $historyLog->action = $action; // Jenis aksi (create, update, delete)

        // Jika aksi adalah update, simpan data lama dan baru
        if ($action === 'update') {
            $historyLog->old_data = json_encode($this->getOriginal()); // Data lama
            $historyLog->new_data = json_encode($changes); // Data baru
        } elseif ($action === 'create') {
            $historyLog->new_data = json_encode($changes); // Data baru (untuk create)
        } elseif ($action === 'delete') {
            $historyLog->old_data = json_encode($this->getOriginal()); // Data lama (untuk delete)
        }

        // Deskripsi perubahan yang lebih jelas
        $historyLog->name = $this->generateChangeDescription($this->getOriginal(), $changes);

        // Menyimpan log perubahan ke dalam tabel history_logs
        $historyLog->save(); // Simpan log ke database
    }

    /**
     * Menyusun deskripsi perubahan yang dilakukan.
     *
     * @param  array  $oldData
     * @param  array  $newData
     * @return string
     */
    protected function generateChangeDescription($oldData, $newData)
    {
        $description = [];

        foreach ($oldData as $key => $value) {
            if (array_key_exists($key, $newData) && $value != $newData[$key]) {
                $description[] = ucfirst(str_replace('_', ' ', $key)) . ' berubah dari ' . $value . ' menjadi ' . $newData[$key];
            }
        }

        return implode(', ', $description);
    }
}
