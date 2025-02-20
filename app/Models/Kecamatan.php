<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    // Nama tabel (optional, jika tidak sesuai dengan konvensi)
    protected $table = 'kecamatans';


    // Relasi dengan Kelurahan
    public function kelurahans()
{
    return $this->hasMany(Kelurahan::class, 'id_kec', 'id_kec');
}

}
