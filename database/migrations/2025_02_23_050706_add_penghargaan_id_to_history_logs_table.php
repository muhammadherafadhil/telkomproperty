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
        $table->unsignedBigInteger('penghargaan_id')->nullable();
        $table->foreign('penghargaan_id')->references('id')->on('penghargaans')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('history_logs', function (Blueprint $table) {
        $table->dropForeign(['penghargaan_id']);
        $table->dropColumn('penghargaan_id');
    });
}

};
