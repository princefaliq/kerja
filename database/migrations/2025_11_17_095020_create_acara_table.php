<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acara', function (Blueprint $table) {
            $table->id();
            $table->string('nama_acara');
            $table->string('slug')->unique();
            $table->date('tanggal_mulai')->nullable();
            $table->time('waktu_mulai')->nullable();    // contoh: "08:00"
            $table->date('tanggal_selesai')->nullable();
            $table->time('waktu_selesai')->nullable();  // contoh: "16:00"
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acara');
    }
}
