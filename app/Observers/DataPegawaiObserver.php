<?php

namespace App\Observers;

use App\Models\DataPegawai;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;

class DataPegawaiObserver
{
    /**
     * Menangani event 'updated' pada DataPegawai.
     *
     * @param  \App\Models\DataPegawai  $dataPegawai
     * @return void
     */
    public function updated(DataPegawai $dataPegawai)
    {
        // Ambil data lama dan baru
        $oldData = $dataPegawai->getOriginal();  // Data sebelum perubahan
        $newData = $dataPegawai->getAttributes(); // Data setelah perubahan

        // Tentukan action
        $action = 'Update'; // Jenis aksi, bisa juga 'Create' atau 'Delete'

        // Menyusun deskripsi perubahan yang lebih profesional
        $name = $this->generateChangeDescription($oldData, $newData);

        // Menyimpan log perubahan ke dalam tabel history_logs
        HistoryLog::create([
            'data_pegawai_id' => $dataPegawai->id,
            'action' => $action,
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'name' => $name,
            'user_id' => Auth::id(), // Mengambil ID pengguna yang sedang login
        ]);
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
