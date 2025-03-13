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
        Schema::create('pendidikans', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 10)->nullable();
            $table->string('jenjang_pendidikan', 45)->nullable();
            $table->string('institusi', 45)->nullable();
            $table->string('jurusan', 45)->nullable();
            $table->string('tahun_lulus', 45)->nullable();
            $table->text('lamp_ijazah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikans');
    }
};
