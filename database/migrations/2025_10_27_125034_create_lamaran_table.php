<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLamaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lamaran', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (pelamar)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke tabel lowongan
            $table->foreignId('lowongan_id')->constrained('lowongan')->onDelete('cascade');

            // Status lamaran
            $table->enum('status', ['dikirim', 'diterima', 'ditolak'])->default('dikirim');
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
        Schema::dropIfExists('lamaran');
    }
}
