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
        Schema::create('keterampilans', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 10)->nullable();
            $table->string('keterampilan', 45)->nullable();
            $table->text('lamp_keterampilan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterampilans');
    }
};
