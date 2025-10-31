<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelamar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik')->unique(); // NIK
            $table->date('tgl_lahir'); // Tanggal Lahir
            $table->string('provinsi'); // Alamat
            $table->string('kabupaten'); // Alamat
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('alamat');

            // Jenis Kelamin
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']); // Jenis Kelamin

            // Status Pernikahan
            $table->enum('status_pernikahan', [
                'Belum Kawin',
                'Kawin',
            ]); // Status Pernikahan

            // Disabilitas
            $table->enum('disabilitas', ['iya', 'tidak']); // Disabilitas

            // File upload (PDF)
            $table->string('ktp')->nullable();          // Upload KTP (PDF)
            $table->string('cv')->nullable();            // Upload CV (PDF)
            $table->string('ijazah')->nullable();        // Upload Ijazah Terakhir (PDF)
            $table->string('ak1')->nullable();           // Upload Kartu Pencari Kerja (AK1)
            $table->string('sertifikat')->nullable();    // Upload sertifikat/pengalaman kerja (opsional)
            $table->string('syarat_lain')->nullable();   // Upload syarat lain (opsional)

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
        Schema::dropIfExists('pelamar');
    }
}
