<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama properti
            $table->text('description'); // Deskripsi properti
            $table->string('location'); // Lokasi properti
            $table->decimal('price', 10, 2); // Harga properti
            $table->string('type'); // Jenis properti (misal: kantor, gedung, dll.)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
