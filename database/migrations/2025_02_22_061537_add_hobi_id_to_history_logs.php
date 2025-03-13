<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('hobi_id')->nullable();  // Menambah kolom hobi_id
            $table->foreign('hobi_id')->references('id')->on('hobis')->onDelete('cascade');  // Menambahkan relasi dengan tabel hobis
        });
    }

    /**
     * Membatalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropForeign(['hobi_id']);  // Menghapus relasi dengan tabel hobis
            $table->dropColumn('hobi_id');  // Menghapus kolom hobi_id
        });
    }
};
