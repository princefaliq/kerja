<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('kode_acara'); // relasi logika ke acara/jenis absensi
            $table->string('token')->unique(); // token unik di QR
            $table->boolean('digunakan')->default(false); // sudah dipakai atau belum
            $table->timestamp('expired_at'); // waktu kedaluwarsa token
            $table->timestamps();
            $table->index(['kode_acara', 'expired_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qr_tokens');
    }
}
