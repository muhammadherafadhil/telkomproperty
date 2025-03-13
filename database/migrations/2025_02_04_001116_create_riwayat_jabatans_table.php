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
        Schema::create('riwayat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 10)->nullable();
            $table->string('nama_jabatan', 45)->nullable();
            $table->date('tanggal_menjabat', 45)->nullable();
            $table->date('tanggal_akhir_jabatan', 45)->nullable();
            $table->string('lokasi_penempatan', 45)->nullable();
            $table->text('lamp_jabatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatans');
    }
};
