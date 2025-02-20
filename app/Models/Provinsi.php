<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    // Nama tabel (optional, jika tidak sesuai dengan konvensi)
    protected $table = 'provinsis';

    // Relasi dengan Kabupaten
    public function kabupatens()
{
    return $this->hasMany(Kabupaten::class, 'id_prov', 'id_prov');
}

}
