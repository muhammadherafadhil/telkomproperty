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
        'hobi',
        'lamp_kegiatan_hobi',
        'pelatihan',
        'tanggal_pelatihan',
        'tanggal_selesai_pelatihan',
        'nama_penyelenggara',
        'lamp_pelatihan',
        'jenjang_pendidikan',
        'institusi',
        'jurusan',
        'tahun_lulus',
        'lamp_ijazah',
        'penghargaan',
        'tahun_penghargaan',
        'nama_penghargaan',
        'lamp_penghargaan',
        'nama_jabatan',
        'tanggal_menjabat',
        'tanggal_akhir_jabatan',
        'lokasi_penempatan',
        'lamp_jabatan',
        'keterampilan',
        'lamp_keterampilan',
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
        'lamp_prestasi',
        'avatar_karyawan',
    ];
    
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'prov', 'id_prov');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kab_kot', 'id_kab');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kec', 'id_kec');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'des_kel', 'id_kel');
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    // Event yang dipanggil setelah record diubah (create, update, delete)
    protected static function booted()
    {
        // Setelah data pegawai dibuat
        static::created(function ($dataPegawai) {
            $dataPegawai->logHistory('create');
        });

        // Setelah data pegawai diperbarui
        static::updated(function ($dataPegawai) {
            $dataPegawai->logHistory('update');
        });

        // Setelah data pegawai dihapus
        static::deleted(function ($dataPegawai) {
            $dataPegawai->logHistory('delete');
        });
    }

    // Fungsi untuk menyimpan log history ke tabel history_logs
    public function logHistory($action)
    {
        $changes = $this->getChanges(); // Mengambil data yang berubah

        // Menyimpan log ke tabel history_logs
        $historyLog = new HistoryLog();
        $historyLog->data_pegawai_id = $this->id; // ID pegawai yang berubah
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
