<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    // Nama tabel (optional, jika tidak sesuai dengan konvensi)
    protected $table = 'kabupatens';

    // Relasi dengan Provinsi
    public function kecamatans()
{
    return $this->hasMany(Kecamatan::class, 'id_kab', 'id_kab');
}

}
