<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama_posisi',
        'klasifikasi_posisi',
        'lokasi_kerja',
        'unit_kerja',
        'psa',
        'nik_tg',
        'nama_lengkap',
        'level_eksis',
        'tanggal_level',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'sex',
        'gol_darah',
        'pendidikan_terakhir',
        'aktif_or_pensiun',
        'nomor_ktp',
        'alamat',
        'rt_rw',
        'des_kel',
        'kec',
        'kab_kot',
        'prov',
        'kode_pos',
        'no_hp',
        'email_telpro',
        'other_email',
        'tanggal_mulai_kerja',
        'status_karyawan',
        'no_sk_kartap',
        'tanggal_kartap',
        'no_sk_promut',
        'tanggal_promut',
        'kode_divisi',
        'nama_divisi',
        'tgl_posisi',
        'nama_kelompok_usia',
        'kode_kelompok_usia',
        'nama_employee_group',
        'kota_kerja_now',
        'unit_kerja_now',
        'no_kontrak',
        'mli_kontrak',
        'end_kontrak',
        'formasi_jabatan',
        'status_nikah',
        'tanggal_nikah',
        'tang_kel',
        'no_kk',
        'nama_suami_or_istri',
        'nomor_hp_pasangan',
        'nama_anak_1',
        'tgl_lahir_anak_1',
        'nama_anak_2',
        'tgl_lahir_anak_2',
        'nama_anak_3',
        'tgl_lahir_anak_3',
        'nama_ayah_kandung',
        'nama_ibu_kandung',
        'no_bpjs_kes',
        'no_bpjs_ket',
        'no_telkomedika',
        'npwp',
        'nama_bank',
        'no_rekening',
        'nama_rekening',
        'lamp_foto_karyawan',
        'lamp_ktp',
        'lamp_sk_kartap',
        'lamp_sk_promut',
        'lamp_kontrak',
        'lamp_buku_nikah',
        'lamp_kk',
        'lamp_ktp_pasangan',
        'lamp_akta_1',
        'lamp_akta_2',
        'lamp_akta_3',
        'lamp_bpjs_kes',
        'lamp_bpjs_tk',
        'lamp_kartu_npwp',
        'lamp_buku_rekening',
        'avatar_karyawan',
    ];

    // Relasi dengan User
    // Model DataPegawai (app/Models/DataPegawai.php)

public function user()
{
    return $this->hasOne(User::class, 'nik', 'nik'); // Relasi ke tabel users
}


}
