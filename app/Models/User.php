<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',       // Nomor Induk Karyawan
        'name',      // Nama pengguna
        'email',     // Email pengguna
        'password',  // Password pengguna
        'role',      // Role pengguna (admin/user)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Menghubungkan User dengan DataPegawai berdasarkan nik
     */
    public function dataPegawai()
    {
        return $this->hasOne(DataPegawai::class, 'nik', 'nik');
    }

    /**
     * Cek apakah pengguna adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';  // Pastikan role pengguna adalah 'admin'
    }

    /**
     * Cek apakah pengguna adalah pegawai
     */
    public function isEmployee()
    {
        return $this->role === 'user'; // Memastikan role pengguna adalah 'user'
    }
}
