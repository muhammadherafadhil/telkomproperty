<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryLogsTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel history_logs dan menambahkan kolom user_id.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('history_logs', function (Blueprint $table) {
            $table->id(); // Kolom ID unik untuk setiap log

            // Menambahkan foreign key data_pegawai_id yang mengarah ke tabel data_pegawais
            $table->foreignId('data_pegawai_id')
                  ->constrained('data_pegawais')  // Menyambungkan ke tabel data_pegawais
                  ->onDelete('cascade');  // Menghapus history jika data pegawai dihapus

            // Menambahkan action untuk mengetahui jenis tindakan (create, update, delete)
            $table->string('action')->comment('Create, Update, Delete');
            
            // Menyimpan data lama yang akan diubah
            $table->json('old_data')->nullable(); // Kolom untuk menyimpan data lama
            
            // Menyimpan data baru setelah perubahan
            $table->json('new_data')->nullable(); // Kolom untuk menyimpan data baru

            $table->text('old_attachments')->nullable(); // Lampiran lama
            
            $table->text('new_attachments')->nullable(); // Lampiran baru

            // Nama perubahan yang dilakukan dengan keterangan detail
            $table->text('name')->nullable()->comment('Deskripsi perubahan yang dilakukan, seperti: "User A mengubah NIK pegawai dari X ke Y"');

            // Menambahkan kolom untuk menyimpan informasi pengguna yang melakukan perubahan
            $table->unsignedBigInteger('user_id')->nullable(); // Menyimpan ID user yang melakukan perubahan
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');  // Menghubungkan ke tabel users
            
            // Kolom waktu untuk mencatat kapan perubahan dilakukan
            $table->timestamps(); // Menyimpan waktu perubahan dengan created_at dan updated_at
        });
    }

    /**
     * Balikkan perubahan pada migrasi.
     *
     * @return void
     */
    public function down(): void
    {
        // Menghapus foreign key dan kolom user_id sebelum menghapus tabel
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Menghapus constraint foreign key
            $table->dropColumn('user_id'); // Menghapus kolom user_id
        });

        // Menghapus tabel history_logs
        Schema::dropIfExists('history_logs');
    }
}
