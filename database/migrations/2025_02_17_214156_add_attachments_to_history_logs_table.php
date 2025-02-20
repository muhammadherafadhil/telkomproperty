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
            $table->text('old_attachments')->nullable(); // Menambahkan kolom old_attachments
            $table->text('new_attachments')->nullable(); // Menambahkan kolom new_attachments
        });
    }

    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropColumn('old_attachments'); // Menghapus kolom old_attachments
            $table->dropColumn('new_attachments'); // Menghapus kolom new_attachments
        });
    }
};
