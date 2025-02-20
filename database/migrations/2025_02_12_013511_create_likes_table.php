<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            // Menambahkan kolom user_id yang merujuk pada pengguna yang memberikan like
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Menambahkan kolom log_id untuk menghubungkan like dengan riwayat log
            $table->foreignId('log_id')->constrained('history_logs')->onDelete('cascade');
            // Kolom status untuk menentukan apakah like aktif atau tidak (misalnya, like yang dihapus)
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
