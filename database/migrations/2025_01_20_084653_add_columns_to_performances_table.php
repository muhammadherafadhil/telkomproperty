<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPerformancesTable extends Migration
{
    /**
     * Menjalankan migrasi untuk menambahkan kolom ke tabel performances.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->integer('score')->default(0);  // Kolom score dengan default value
            $table->text('feedback')->nullable();  // Kolom feedback, opsional
        });
    }

    /**
     * Rollback migrasi untuk menghapus kolom dari tabel performances.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->dropColumn(['score', 'feedback']);
        });
    }
}
