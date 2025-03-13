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
            $table->unsignedBigInteger('pelatihan_id')->nullable(); // Add pelatihan_id
            $table->foreign('pelatihan_id')->references('id')->on('pelatihans')->onDelete('cascade'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_id']);
            $table->dropColumn('pelatihan_id');
        });
    }
};
