<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogIdToLikesAndComments extends Migration
{
    public function up()
    {
        // Cek apakah tabel 'likes' ada sebelum mengubahnya
        if (Schema::hasTable('likes')) {
            // Tambahkan kolom log_id ke tabel 'likes' jika kolom tersebut belum ada
            Schema::table('likes', function (Blueprint $table) {
                if (!Schema::hasColumn('likes', 'log_id')) {
                    $table->foreignId('log_id')->nullable()->constrained('history_logs')->onDelete('cascade');
                }
            });
        }

        // Cek apakah tabel 'comments' ada sebelum mengubahnya
        if (Schema::hasTable('comments')) {
            // Tambahkan kolom log_id ke tabel 'comments' jika kolom tersebut belum ada
            Schema::table('comments', function (Blueprint $table) {
                if (!Schema::hasColumn('comments', 'log_id')) {
                    $table->foreignId('log_id')->nullable()->constrained('history_logs')->onDelete('cascade');
                }
            });
        }
    }

    public function down()
    {
        // Cek apakah tabel 'likes' ada sebelum mengubahnya
        if (Schema::hasTable('likes')) {
            Schema::table('likes', function (Blueprint $table) {
                if (Schema::hasColumn('likes', 'log_id')) {
                    // Hapus foreign key constraint jika ada
                    $table->dropForeign(['log_id']);
                    // Hapus kolom log_id
                    $table->dropColumn('log_id');
                }
            });
        }

        // Cek apakah tabel 'comments' ada sebelum mengubahnya
        if (Schema::hasTable('comments')) {
            Schema::table('comments', function (Blueprint $table) {
                if (Schema::hasColumn('comments', 'log_id')) {
                    // Hapus foreign key constraint jika ada
                    $table->dropForeign(['log_id']);
                    // Hapus kolom log_id
                    $table->dropColumn('log_id');
                }
            });
        }
    }
}
