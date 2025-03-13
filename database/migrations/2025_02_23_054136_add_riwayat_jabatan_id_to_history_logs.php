<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('riwayat_jabatan_id')->nullable();
            $table->foreign('riwayat_jabatan_id')->references('id')->on('riwayat_jabatans')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropForeign(['riwayat_jabatan_id']);
            $table->dropColumn('riwayat_jabatan_id');
        });
    }
    
};
