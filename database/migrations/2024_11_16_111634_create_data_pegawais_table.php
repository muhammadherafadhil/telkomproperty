<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama_posisi')->nullable();
            $table->string('klasifikasi_posisi')->nullable();
            $table->string('lokasi_kerja', 150)->nullable();
            $table->string('unit_kerja', 150)->nullable();
            $table->string('psa', 45)->nullable();
            $table->string('nik_tg', 10)->nullable();
            $table->string('nama_lengkap', 150)->nullable();
            $table->string('level_eksis', 8)->nullable();
            $table->date('tanggal_level')->nullable();
            $table->string('tempat_lahir', 150)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('sex', 10)->nullable();
            $table->string('gol_darah', 4)->nullable();
            $table->string('pendidikan_terakhir', 255)->nullable();
            $table->string('aktif_or_pensiun', 255)->nullable();
            $table->string('nomor_ktp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt_rw', 150)->nullable();
            $table->string('des_kel', 150)->nullable();
            $table->string('kec', 150)->nullable();
            $table->string('kab_kot', 150)->nullable();
            $table->string('prov', 150)->nullable();
            $table->string('kode_pos', 20)->nullable();
            $table->string('no_hp', 50)->nullable();
            $table->string('email_telpro', 150)->nullable();
            $table->string('other_email', 150)->nullable();
            $table->date('tanggal_mulai_kerja')->nullable();
            $table->string('status_karyawan', 45)->nullable();
            $table->string('no_sk_kartap', 100)->nullable();
            $table->date('tanggal_kartap')->nullable();
            $table->string('no_sk_promut', 100)->nullable();
            $table->date('tanggal_promut')->nullable();
            $table->string('kode_divisi', 255)->nullable();
            $table->string('nama_divisi', 255)->nullable();
            $table->date('tgl_posisi')->nullable();
            $table->string('nama_kelompok_usia', 255)->nullable();
            $table->string('kode_kelompok_usia', 255)->nullable();
            $table->string('nama_employee_group', 255)->nullable();
            $table->string('kota_kerja_now', 255)->nullable();
            $table->string('unit_kerja_now', 255)->nullable();
            $table->string('no_kontrak', 100)->nullable();
            $table->string('mli_kontrak', 100)->nullable();
            $table->string('end_kontrak', 100)->nullable();
            $table->string('formasi_jabatan', 255)->nullable();
            $table->string('status_nikah', 20)->nullable();
            $table->date('tanggal_nikah')->nullable();
            $table->string('tang_kel', 20)->nullable();
            $table->string('no_kk', 45)->nullable();
            $table->string('nama_suami_or_istri', 100)->nullable();
            $table->string('nomor_hp_pasangan', 15)->nullable();
            $table->string('nama_anak_1', 100)->nullable();
            $table->string('tgl_lahir_anak_1', 255)->nullable();
            $table->string('nama_anak_2', 100)->nullable();
            $table->date('tgl_lahir_anak_2')->nullable();
            $table->string('nama_anak_3', 100)->nullable();
            $table->date('tgl_lahir_anak_3')->nullable();
            $table->string('nama_ayah_kandung', 100)->nullable();
            $table->string('nama_ibu_kandung', 100)->nullable();
            $table->string('no_bpjs_kes', 30)->nullable();
            $table->string('no_bpjs_ket', 30)->nullable();
            $table->string('no_telkomedika', 255)->nullable();
            $table->string('npwp', 45)->nullable();
            $table->string('nama_bank', 45)->nullable();
            $table->string('no_rekening', 20)->nullable();
            $table->string('nama_rekening', 45)->nullable();
            $table->text('lamp_foto_karyawan')->nullable();
            $table->text('lamp_ktp')->nullable();
            $table->text('lamp_sk_kartap')->nullable();
            $table->text('lamp_sk_promut')->nullable();
            $table->text('lamp_kontrak')->nullable();
            $table->text('lamp_buku_nikah')->nullable();
            $table->text('lamp_kk')->nullable();
            $table->text('lamp_ktp_pasangan')->nullable();
            $table->text('lamp_akta_1')->nullable();
            $table->text('lamp_akta_2')->nullable();
            $table->text('lamp_akta_3')->nullable();
            $table->text('lamp_bpjs_kes')->nullable();
            $table->text('lamp_bpjs_tk')->nullable();
            $table->text('lamp_kartu_npwp')->nullable();
            $table->text('lamp_buku_rekening')->nullable();
            $table->text('lamp_prestasi')->nullable();
            $table->text('avatar_karyawan')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */     
    public function down(): void
    {
        Schema::dropIfExists('data_pegawais');
    }
};
