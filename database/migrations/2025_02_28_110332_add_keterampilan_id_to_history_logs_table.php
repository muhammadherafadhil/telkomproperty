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
            $table->unsignedBigInteger('keterampilan_id')->nullable(); // Add keterampilan_id column
            $table->foreign('keterampilan_id')->references('id')->on('keterampilans')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropForeign(['keterampilan_id']);
            $table->dropColumn('keterampilan_id');
        });
    }
};
