<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformancesTable extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel performances.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();  // ID unik untuk setiap record
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi dengan tabel 'users'
            $table->string('title');  // Kolom title
            $table->text('description');  // Kolom description
            $table->integer('rating');  // Kolom rating
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Rollback migrasi untuk menghapus tabel performances.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performances');
    }
}
