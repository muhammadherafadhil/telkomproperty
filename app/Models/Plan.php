<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'judul', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'status', 'user_id'
    ];

    // Menyatakan bahwa kolom 'tanggal_mulai' dan 'tanggal_selesai' adalah tanggal
    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];
}
