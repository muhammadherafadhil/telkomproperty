<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',      // NIK diambil dari tabel users
        'nama',     // Nama pegawai
        'jabatan',  // Jabatan pegawai
    ];

    // Relasi dengan User
    // Model DataPegawai (app/Models/DataPegawai.php)

public function user()
{
    return $this->hasOne(User::class, 'nik', 'nik'); // Relasi ke tabel users
}


}
