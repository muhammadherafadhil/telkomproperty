<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            // Pastikan data_pegawai_id adalah foreign key yang valid
            $table->unsignedBigInteger('data_pegawai_id')->nullable();
            $table->foreign('data_pegawai_id')->references('id')->on('data_pegawais')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropForeign(['data_pegawai_id']);
            $table->dropColumn('data_pegawai_id');
        });
    }
};
