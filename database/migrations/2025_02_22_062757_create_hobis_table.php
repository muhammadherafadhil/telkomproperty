<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel hobis.
     */
    public function up(): void
    {
        Schema::create('hobis', function (Blueprint $table) {
            $table->id();  // Kolom ID auto increment
            $table->string('nik', 10)->nullable();  // Kolom untuk NIK (Nomor Induk Kependudukan)
            $table->string('hobi', 45)->nullable();  // Kolom untuk nama hobi
            $table->text('lamp_kegiatan_hobi')->nullable();  // Kolom untuk lampiran kegiatan hobi
            $table->timestamps();  // Kolom timestamps (created_at, updated_at)
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('hobis');
    }
};
