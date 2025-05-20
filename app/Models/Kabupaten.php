<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupatens';
    protected $primaryKey = 'id_kab';
    public $timestamps = true;

    protected $fillable = [
        'id_kab',
        'nama_kabupaten',
        // Tambahkan kolom lain jika perlu
    ];

    /**
     * Relasi ke kecamatan
     */
    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class, 'id_kab', 'id_kab');
    }

    /**
     * Event hook untuk mencatat log
     */
    protected static function booted()
    {
        static::created(function ($kabupaten) {
            $kabupaten->logHistory('create');
        });

        static::updated(function ($kabupaten) {
            $kabupaten->logHistory('update');
        });

        static::deleted(function ($kabupaten) {
            $kabupaten->logHistory('delete');
        });
    }

    /**
     * Mencatat log perubahan
     */
    public function logHistory($action)
    {
        $changes = $this->getChanges();
        $original = $this->getOriginal();

        $historyLog = new HistoryLog();
        $historyLog->data_pegawai_id = $this->id_kab;
        $historyLog->action = $action;

        // Format readable untuk kabupaten
        $displayKabupaten = 'Kabupaten ' . $this->nama_kabupaten;

        if ($action === 'create') {
            $historyLog->new_data = json_encode([
                'nama_kabupaten' => $displayKabupaten,
                'data' => $changes
            ]);
        }

        if ($action === 'update') {
            $historyLog->old_data = json_encode([
                'nama_kabupaten' => 'Kabupaten ' . $original['nama_kabupaten'],
                'data' => $original
            ]);
            $historyLog->new_data = json_encode([
                'nama_kabupaten' => $displayKabupaten,
                'data' => $changes
            ]);
        }

        if ($action === 'delete') {
            $historyLog->old_data = json_encode([
                'nama_kabupaten' => 'Kabupaten ' . $original['nama_kabupaten'],
                'data' => $original
            ]);
        }

        $historyLog->name = $this->generateChangeDescription($original, $changes, $displayKabupaten);
        $historyLog->save();
    }

    /**
     * Buat deskripsi perubahan yang mudah dibaca
     */
    protected function generateChangeDescription($oldData, $newData, $kabupatenName)
    {
        $description = [$kabupatenName];

        foreach ($newData as $key => $newValue) {
            $oldValue = $oldData[$key] ?? null;
            if ($oldValue != $newValue) {
                $label = ucfirst(str_replace('_', ' ', $key));
                $description[] = "$label berubah dari '$oldValue' menjadi '$newValue'";
            }
        }

        return implode(', ', $description);
    }

    /**
     * Accessor: nama kabupaten
     */
    public function getDisplayNameAttribute()
    {
        return $this->nama_kabupaten;
    }

    /**
     * Tampilkan nama kabupaten saat model di-cast ke string
     */
    public function __toString()
    {
        return $this->nama_kabupaten;
    }
}
