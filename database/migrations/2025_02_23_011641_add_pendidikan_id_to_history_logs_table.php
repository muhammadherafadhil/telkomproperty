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
        $table->unsignedBigInteger('pendidikan_id')->nullable(); // Menambahkan kolom pendidikan_id
        $table->foreign('pendidikan_id')->references('id')->on('pendidikans')->onDelete('cascade'); // Jika ingin foreign key
    });
}

public function down()
{
    Schema::table('history_logs', function (Blueprint $table) {
        $table->dropForeign(['pendidikan_id']); // Hapus foreign key jika ada
        $table->dropColumn('pendidikan_id'); // Hapus kolom pendidikan_id
    });
}

};
